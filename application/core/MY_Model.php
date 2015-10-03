<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model
{
    protected $logger;
    protected $tableName;
    protected $uniqueKeys = array(
        'id'
    );

    public function __construct()
    {
        parent::__construct();

        $CI = & get_instance();
        $this->logger = $CI->logger;

        $this->load->database();
        $this->tableName = mb_strtolower(str_replace('_model', '', get_class($this)));
        $this->fieldTypes = array();
    }

    protected function createCondition($conds)
    {
        if (!is_array($conds)) {
            $conds = array(
                $conds
            );
        }
        if (count($this->uniqueKeys) == count($conds)) {
            $cond = array();
            foreach ($conds as $index => $value) {
                $cond+= array(
                    $this->uniqueKeys[$index] => $value
                );
            }
            return $cond;
        }

        return FALSE;
    }

    public function count()
    {
        return $this->db->get($this->tableName)->num_rows();
    }

    public function fetch()
    {
        $results = array();
        $this->db->order_by('id');
        $query = $this->db->get($this->tableName);
        if ($query->num_rows() > 0) {
            $rows = $query->result_object();

            foreach ($rows as $row) {
                array_push($results, self::convert($row));
            }
            return $results;
        }

        return FALSE;
    }

    public function info($conds)
    {
        $query = $this->db;
        $cond = $this->createCondition($conds);

        if ($cond) {
            return self::convert($query->where($cond)->get($this->tableName)->row());
        }

        return FALSE;
    }

    public function insert($data = null, $return = TRUE)
    {
        if ($data === null) {
            $data = $this;
        }
        if (!$this->db->insert($this->tableName, $data)) {
            return FALSE;
        }
        if ($return) {
            return $this->db->insert_id();
        }
        else {
            return TRUE;
        }
    }

    public function update($conds, $data = null)
    {
        if ($data === null) {
            $data = $this;
        }
        $cond = $this->createCondition($conds);
        if ($cond) {
            if (!$this->db->where($cond)->update($this->tableName, $data)) {
                return FALSE;
            }
        }
    }

    public function destroy($conds)
    {
        $cond = $this->createCondition($conds);
        if ($cond) {
            if (!$this->db->where($cond)->delete($this->tableName)) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function convert($result)
    {
        if ($result) {
            foreach ($result as $key => $value) {
                foreach ($this->fieldTypes as $name => $type) {
                    if ($key == $name) {
                        if ($type == 'INT') {
                            $result->$key = (int)$value;
                        }
                        else if ($type == 'FLOAT') {
                            $result->$key = (float)$value;
                        }
                    }
                }
            }
        }
        return $result;
    }
}
// End of MY_Model class

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
