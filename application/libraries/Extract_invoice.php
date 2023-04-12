<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

defined('BASEPATH') OR exit('No direct script access allowed');


class Extract_invoice {

    protected $ci;

	function __construct(){
        $this->ci =& get_instance();
        $this->ci->load->model('customModels/JsonDat_model','jsondat');
		$this->ci->load->model('customModels/FactDat_model','factdat');
    }


    function imgData($dataImg){
        // $this->ci->load->model('usuario_model');
        $client = new Client([
            'base_uri' => 'https://api.mindee.net/v1/products/mindee/invoices/v4/predict',
            'timeout'  => 5.0,
        ]);
        $path = $dataImg['full_path'];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        Try {

            $response = $client->post(
                '', [
                    'headers' => [
                        'Accept'                => 'application/json',
                        'Authorization'         => 'Token 7858cc9e0c82d7cf7c1200fd51a2f4be',
                    ],
                    'form_params' => [
                        'document' => $base64
                    ]
                ],
            );

            $obj = $response->getBody()->getContents();

            $result = json_decode($obj);
			$jsonDat=json_encode($result, JSON_PRETTY_PRINT);

            // header('Content-type: text/javascript');
			// echo "Los Datos ya se encuentran Registrados: ".$jsonDat;

            $preData=$result->document->inference->pages[0]->prediction;
			//ARRAY DATOS PARA INSERTAR JSON
			$datJsonInsert['idDoc']=$preData->invoice_number->value;
			$datJsonInsert['jsonDatFact']=$jsonDat;


			//ARRAY DATOS PARA INSERTAR CAMPOS DE INTERES
			$datFactInsert['idDocJson']=$preData->invoice_number->value;
			$datFactInsert['custName']=$preData->customer_name->value;
			$datFactInsert['date']=$preData->date->value;
			$datFactInsert['docType']=$preData->document_type->value;
			$datFactInsert['dueDate']=$preData->due_date->value;
			$datFactInsert['invoNum']=$preData->invoice_number->value;
			$datFactInsert['taxes']=$preData->taxes[0]->value;
			$datFactInsert['totAmount']=$preData->total_amount->value;
			$datFactInsert['totNet']=$preData->total_net->value;
			$datItemsInsert=$preData->line_items;

            //CHECK EXISTENCIA DEL
			$confirm=$this->ci->jsondat->existCodeFact($datJsonInsert['idDoc']);
			if(!$confirm[0] && $confirm[1]==null):
				if($this->ci->jsondat->addJsonDat($datJsonInsert)):
					if($this->ci->factdat->addFactDat($datFactInsert,$datItemsInsert)):
						header('Content-type: text/javascript');
						echo "Los Datos se registraron con Éxito..: ".$jsonDat;
					else:
						$this->layoutView("Los datos ectraidos para campos de interes no fueron guardados.");
					endif;
					
				else:
					$this->layoutView("Los datos extraidos para formato JSON no fueron guardados.");
				endif;
			else:
				// $this->layoutView("Los datos ya Existen!!");
				header('Content-type: text/javascript');
				echo "Los Datos ya se encuentran Registrados: ".$jsonDat;
			endif;

            // return $obj;

        } catch(\Exception $e) {
            echo $e->getMessage();
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();

            echo $responseBody;
            exit;
        }
        
    }

}
