<?php

    class FactDat_model extends CI_Model {
        
        public function addFactDat($factDat,$itemsFact)
        {
            try{
                $this->db->db_debug = false;

                $res=$this->db->insert('datafields',$factDat);
                if(!$res)
                {
                    $error = $this->db->error();
                    //return array $error['code'] & $error['message']
                    throw new Exception($error['message']);
                }
                else
                {
                    foreach ($itemsFact as $item){
                        $data['idDocFact '] = $factDat['idDocJson'];
                        $data['unitPrice '] = $item->unit_price;
                        $data['totAmount '] = $item->total_amount;
                        $data['quantity '] = $item->quantity;
                        $data['description '] = $item->description;
                        $this->db->insert('itemsfact',$data);
                        if(!$res)
                        {
                            $error = $this->db->error();
                            //return array $error['code'] & $error['message']
                            throw new Exception($error['message']);
                            
                        }
                    }
                    return true;
                }
            }catch(\Exception $e){
                return false;
            }
        }
    } 

?>