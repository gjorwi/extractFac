<?php

    class JsonDat_model extends CI_Model {

        public function addJsonDat($jsonDat)
        {
            try{
                $this->db->db_debug = false;
                $res=$this->db->insert('datajson',$jsonDat);

                if(!$res)
                {
                    $error = $this->db->error();
                    //return array $error['code'] & $error['message']
                    throw new Exception($error['message']);
                }
                else
                {
                    return true;
                }
                
            }catch(\Exception $e){
                return false;
            }
        }
        public function existCodeFact($idDoc)
        {
            try{
                $this->db->db_debug = false;
                $this->db->select('*');
                $this->db->where('idDoc',$idDoc);
                $this->db->from('datajson');
                $res=$this->db->get();
                if(!$res)
                {
                    $error = $this->db->error();
                    //return array $error['code'] & $error['message']
                    throw new Exception($error['message']);
                }
                else
                {
                    if($res->num_rows()>=1){
                        return [true,$res->result_array()];
                    }else{
                        return [false,null];
                    }
                }
                
            }catch(\Exception $e){
                $response = $e->getMessage();
                return [false,$response];
            }
        }
    } 

?>