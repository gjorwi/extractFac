<?php

    class FactDat_model extends CI_Model {
        
        public function addFactDat($factDat,$itemsFact)
        {
            try{
                // print_r($factDat['idDocJson']);
                // echo "///////////////////////////";
                // var_dump($itemsFact);
                $this->db->insert('datafields',$factDat);
                foreach ($itemsFact as $item){
                    $data['idDocFact '] = $factDat['idDocJson'];
                    $data['unitPrice '] = $item->unit_price;
                    $data['totAmount '] = $item->total_amount;
                    $data['quantity '] = $item->quantity;
                    $data['description '] = $item->description;
                    $this->db->insert('itemsfact',$data);
                }
                return true;
            }catch(\Exception $e){
                return false;
            }
        }
    } 

?>