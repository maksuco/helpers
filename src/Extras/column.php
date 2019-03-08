<?php

  //PARSES, ADD, DELETE //UN FINISH
  function column_process($data,$table,$column,$value) {

    $check = column_check($data->$column,$value);
    $new_data = column_process_string($data->$column);
    $type = $new_data[1];
    $new_data = $new_data[0];

    //dd($check,$new_data,$type);
    if($check) {
      //REMOVE
      //unset($new_data[$value]);
      //$existed = false;
      foreach($new_data as $key => $row){
        if($row == $value){
            unset($new_data[$key]);
            $exist = false;
            break;
        }
      }
    } else {
      //ADD
      $new_data[] = $value;
      $exist = true;
    }
    
    if($type != 'explode'){
      $new_data = collect($new_data)->toArray();
      DB::table($table)->where('id', $data->id)->update([$column=>json_encode(array_values($new_data))]);
    } else {
      DB::table($table)->where('id', $data->id)->update([$column=>implode(',',$new_data)]);
    }
    return $exist;
  }


  function column_check($data,$value) {

    $existed = false;
    if(!empty($data) AND $data != '[]') {
      $data = column_process_string($data);
      if(in_array($value,$data,true)){
        $existed = true;
      }
      //foreach($data as $key => $row){
      //  if($row == $value){
      //    $existed = true;
      //dd($row,$key,$value,$existed,$data);
      //    break;
      //  }
      //}
      //dd($data,$existed,$value);
    }
    return $existed;
  }


  function column_process_string($string){
    $data = json_decode($string, true);
    //IF JSON
    if(json_last_error() == JSON_ERROR_NONE) {
      //return $data;
      return [$data,'json'];
    } elseif(is_array($string)) {
      //return $string;
      return [$string,'array'];
    } else {
      return [explode(',',$string),'explode'];
    }

  }
