<?php
class custom_m2m_filter_handler extends views_handler_filter {
  function query() {
    global $user;
    //find the companies that the user is associated with
    $res=db_query("SELECT c.field_company_value FROM {content_field_company} c INNER JOIN {node} n ON n.nid=c.nid WHERE n.uid=%d AND n.type='profile'", $user->uid);
    while($row=db_fetch_array($res)){
      $option_company[]=$row['field_company_value'];
    }
    if(empty($option_company)){
      $this->query->add_where($this->options['group'], "1 != 1");
    }else{
      $option_sales_comp=implode("','",array_fill(0, count($option_company), '%s'));
      //add content_field_company table to query
      $this->query->add_table('content_field_company', NULL, NULL, 'node_content_field_company');
      $join = new views_join();
      $join->construct('content_field_company', 'node', 'vid', 'vid', array(), 'LEFT');
      $alias = $this->query->ensure_table('node_content_field_company', $this->relationship, $join);
      //add a condition to the query to find nodes that are associated with the user's companies or that are associated with the user herself
      call_user_func_array(array($this->query, "add_where"), array_merge(array($this->options['group'], "node.uid=%d OR $alias.field_company_value IN ('$option_sales_comp')", $user->uid), $option_company));
    }
  }
}