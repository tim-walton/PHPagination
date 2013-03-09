<?php

    interface cfg {
        const host = 'localhost';
        const user = 'db_user';
        const pass = 'db_pass';
        const data = 'some_db';
    }


    class pagination implements cfg {
        function __construct($startLimit = 100, $limit = 10, $curPage = 1, $table = 'some_table', $query = null, $order = 'DESC', $orderCol = 'id') {
            $this->link = $this->open_conn();  
            $this->limit = $limit;
            $this->page = $curPage;
            $this->table = $table;
            $this->col = $orderCol;
            $this->total = $this->count_results();
            $this->query = $query;
            $this->tostring = null;
            $this->order = $order;
            $this->slimit = $startLimit;
            $this->count = $this->calc_results();
            if($this->page == '') {
                $this->page = 1;
            }
        }

        protected function open_conn() {
            $link = mysql_pconnect ( cfg::host, cfg::user, cfg::pass, true);
            if($link) {
                mysql_select_db(cfg::data);
                return $link;
            } else {
                die (mysql_error());
            }
        }

        function result($query) {
            $sql = mysql_query($query) or die(mysql_error());
            $data = mysql_fetch_row($sql);
            return $data[0];
        }

        function calc_results() {
            $pages = (int) ceil(round($this->total / $this->limit) + 1);
            if($pages <= 1) {
                $this->count = 1;   
            }
            if($pages > 1) {
                $this->count = $pages;  
            }
            if($this->page <= 1) {
                $this->limit = "0,{$this->slimit}";
            } elseif ($this->page > 1) {
                $start = (int) $this->page * $this->limit;
                $stop = (int) $start + $this->limit;
                $this->limit = "{$start}, {$this->limit}";
            }
            return $pages;
        }

        function count_results() {
            return $this->result("SELECT COUNT(*) FROM {$this->table}");
        }

        function execute() {
            $this->tostring = "{$this->query} ORDER BY {$this->col} {$this->order} LIMIT {$this->limit}"; 
            return array("query"=>$this->tostring, "pages"=>$this->count);
        }

      
    }
?>
