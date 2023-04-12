<?php

    class JsonDat_model extends CI_Model {

        public function addJsonDat($jsonDat)
        {
            try{
                $this->db->insert('datajson',$jsonDat);
                return true;
            }catch(\Exception $e){
                return false;
            }
        }
        public function existCodeFact($idDoc)
        {
            try{
                $this->db->select('*');
                $this->db->where('idDoc',$idDoc);
                $this->db->from('datajson');
                $confirm=$this->db->get();
                if($confirm->num_rows()>=1){
                    return [true,$confirm->result_array()];
                }else{
                    return [false,null];
                }
            }catch(\Exception $e){
                return [false,$e];
            }
        }
    } 

?>