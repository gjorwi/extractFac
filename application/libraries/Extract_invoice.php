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

            // $preData=$result->document->inference->pages[0]->prediction;
            // var_dump(count($result->document->inference->pages));
            if(isset($result->document->inference->pages) && count($result->document->inference->pages)!=0):
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
                $datFactInsert['taxes']=null;
                if(count($preData->taxes)!=0):
                    $datFactInsert['taxes']=$preData->taxes[0]->value;
                endif;
                $datFactInsert['totAmount']=$preData->total_amount->value;
                $datFactInsert['totNet']=$preData->total_net->value;
                $datItemsInsert=$preData->line_items;

                if($datJsonInsert['idDoc']==null):
                    $msg="Se requiere Numero de factura";
                    throw new Exception($msg);
                endif;
                //CHECK EXISTENCIA DEL
                $confirm=$this->ci->jsondat->existCodeFact($datJsonInsert['idDoc']);
                // var_dump($confirm[1]);
                if(!$confirm[0] && $confirm[1]==null):
                    if($this->ci->jsondat->addJsonDat($datJsonInsert)):
                        if($this->ci->factdat->addFactDat($datFactInsert,$datItemsInsert)):
                            // header('Content-type: text/javascript');
                            // echo "Los Datos se registraron con Éxito..: ".$jsonDat;
                            $this->ci->output
                                ->set_status_header(200)
                                ->set_content_type('application/json', 'utf-8')
                                ->set_output($jsonDat)
                                ->_display();
                            exit;
                        else:
                            $msg="Los datos ectraidos para campos de interes no fueron guardados.";
                            throw new Exception($msg);
                        endif;
                        
                    else:
                        $msg="Los datos extraidos para formato JSON no fueron guardados.";
                        throw new Exception($msg);
                    endif;
                    
                elseif(!$confirm[0] && $confirm[1]!=null):
                    $msg=$confirm[1];
                    throw new Exception($msg);
                    
                else:
                    $this->ci->output
                            ->set_status_header(200)
                            ->set_content_type('application/json', 'utf-8')
                            ->set_output($jsonDat)
                            ->_display();
                    exit;
                endif;
            else:
                $msg="No se pudo extraer informacion del archivo";
                throw new Exception($msg);
            endif;


        } catch(Exception $e) {
            $response = $e->getMessage();

            $this->ci->output
                ->set_status_header(500)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(array('response_code' => 500, 'mensaje' => $response), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }
        
    }

}
