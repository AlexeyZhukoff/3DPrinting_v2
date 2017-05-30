<?php
    require_once('/privateconst.php');
    $type = $_GET['type'];
    
    if($type == Commands::GetUsersHtml)
         getUsersHtml();
    //if($type == Commands::GetMaterialsHtml)
    //    getHtml(SheetNames::Materials, 3);
    //if($type == Commands::CreateUser)
    //    createUser();
    //if($type == Commands::RemoveUser)
    //    removeUser();
    //if($type == Commands::CreateMaterial)
    //    createMaterial();
    //if($type == Commands::RemoveMaterial)
    //    removeMaterial();
    //if($type == Commands::ChangeUsersValue)
    //    changeUsersValue();
    //if($type == Commands::ChangeMaterialName)
    //    changeMaterialName();
    //if($type == Commands::ChangeMaterialPrice)
    //    changeMaterialPrice();

    function getUsersHtml(){
        $columnLimit = 1;
        $filename = PrivateConst::File_Name;
        $sheetName = SheetNames::Users;
        $id = loadDocument($filename);
        $rowLimit = 1;
        $userNameValue = getCellValue($id, $sheetName, $rowLimit, 0);
        while(!empty($userNameValue)){
            $userNameValue = getCellValue($id, $sheetName, ++$rowLimit, 0);
        }
        $params = array(
            'id' => $id,
            'sheetname' => $sheetName,
            'endcolumnindex' => 1,
            'endrowindex' => $rowLimit,
        );
        $request = get($params, '/exporttohtml');
        closeDocument($filename, $id);
        
        echo $request['data'];
    }
    //function getHtml($sheetName, $columnLimit){
    //    $filename = PrivateConst::File_Name;
    //    $id = loadDocument($filename);

    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //    );
    //    if($columnLimit > 0){
    //        $params['endcolumnindex'] = $columnLimit;
    //        //$params = array(
    //        //    'id' => $id,
    //        //    'sheetname' => $sheetName,
    //        //    'endcolumnindex' => $columnLimit,
    //        //);
    //    }
    //    $request = get($params, '/exporttohtml');
    //    closeDocument($filename, $id);
    //    
    //    echo $request['data'];
    //}
    //function createUser(){
    //    $filename = PrivateConst::File_Name;
    //    $userName = $_GET[Names::NewUserName];
    //    $id = loadDocument($filename);
    //    insertRow($id, SheetNames::Users, 1);
    //    setCellValue(SheetNames::Users, 1, 0, $filename, $userName, $id);
    //    createFormula($id);
    //    closeDocument($filename, $id);
    //    
    //    getHtml(SheetNames::Users, 0);
    //}
    //function createMaterial(){
    //    $filename = PrivateConst::File_Name;
    //    $materialName = $_GET[Names::NewMaterialName];
    //    $materialDensity = $_GET[Names::NewMaterialDensity];
    //    $materialDiameter = $_GET[Names::NewMaterialDiameter];
    //    $materialPrice = $_GET[Names::NewMaterialPrice];

    //    $id = loadDocument($filename);
    //    insertRow($id, SheetNames::Materials, 1);
    //    setCellValue(SheetNames::Materials, 1, 0, $filename, $materialName, $id);
    //    setCellValue(SheetNames::Materials, 1, 1, $filename, floatval($materialDensity), $id);
    //    setCellValue(SheetNames::Materials, 1, 2, $filename, floatval($materialDiameter), $id);
    //    setCellValue(SheetNames::Materials, 1, 3, $filename, floatval($materialPrice), $id);
    //    setCellFormula($id, SheetNames::Materials, 1, 4, "=((C2*C2*PI()/4)*B2)/1000");
    //    insertMaterialInUsersList($id, $materialName);
    //    closeDocument($filename, $id);

    //    getHtml(SheetNames::Users, 0);
    //}

    //function removeUser(){
    //    $filename = PrivateConst::File_Name;
    //    $userName = $_GET[Names::UserName];
    //    $id = loadDocument($filename);
    //    $row = searchRow(SheetNames::Users, $userName, $id);
    //    removeRow($id, SheetNames::Users, $row);
    //    closeDocument($filename, $id);

    //    getHtml(SheetNames::Users, 0);
    //}
    //function removeMaterial(){
    //    $filename = PrivateConst::File_Name;
    //    $materialName = $_GET[Names::MaterialName];
    //    $id = loadDocument($filename);
    //    $row = searchRow(SheetNames::Materials, $materialName, $id);
    //    removeRow($id, SheetNames::Materials, $row);
    //    $column = searchColumn(SheetNames::Users, $materialName, $id);
    //    removeColumn($id, SheetNames::Users, $column);
    //    $formulaColumn = searchColumn(SheetNames::Users, Names::FormulaColumnName, $id);
    //    updateCellsFormulasAfterRemove(SheetNames::Users, $formulaColumn, $id);

    //    closeDocument($filename, $id);
    //    getHtml(SheetNames::Materials, 3);
    //}

    //function changeUsersValue(){
    //    $filename = PrivateConst::File_Name;
    //    $row = $_GET[Names::Row];
    //    $column = $_GET[Names::Column];
    //    $value = $_GET[Names::NewValue];
    //    $id = loadDocument($filename);
    //    $newval = $value;
    //    if($column !=0) {
    //        $newval = floatval($value);
    //    }
    //    setCellValue(SheetNames::Users, $row, $column, $filename, $newval, $id);
    //    closeDocument($filename, $id);

    //    getHtml(SheetNames::Users, 0);
    //}
    //function changeMaterialName(){
    //    $filename = PrivateConst::File_Name;
    //    $row = $_GET[Names::Row];
    //    $value = $_GET[Names::NewValue];
    //    
    //    $id = loadDocument($filename);
    //    setCellValue(SheetNames::Users, 0, $row, $filename, $value, $id);
    //    setCellValue(SheetNames::Materials, $row, 0, $filename, $value, $id);
    //    closeDocument($filename, $id);

    //    getHtml(SheetNames::Materials, 3);
    //}
    //function changeMaterialPrice(){
    //    $filename = PrivateConst::File_Name;
    //    $row = $_GET[Names::Row];
    //    $value = $_GET[Names::NewValue];
    //    
    //    $id = loadDocument($filename);
    //    setCellValue(SheetNames::Materials, $row, 1, $filename, $value, $id);
    //    closeDocument($filename, $id);

    //    getHtml(SheetNames::Users, 0);
    //}
    //function insertMaterialInUsersList($id, $materialName){
    //    insertColumn($id, SheetNames::Users, 1);
    //    setCellValue(SheetNames::Users, 0, 1, $filename, $materialName, $id);
    //    $formulaColumn = searchColumn(SheetNames::Users, Names::FormulaColumnName, $id);
    //    updateCellsFormulas(SheetNames::Users, $formulaColumn, $id);
    //}
    //function searchRow($sheetName, $text, $id){
    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //        'text' => $text,
    //        'matchentirecellcontents' => TRUE,
    //        'matchcase' => FALSE,
    //    );

    //    $request = get($params, '/searchtext');
    //    $json = json_decode ($request['data']);
    //    
    //    $result = array();
    //    
    //    foreach ($json as $value) {
    //        $result[] = $value ->RowIndex;
    //    }
    //    return $result[0];
    //}
    //function searchColumn($sheetName, $text, $id){
    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //        'text' => $text,
    //        'matchentirecellcontents' => TRUE,
    //        'matchcase' => FALSE,
    //    );

    //    $request = get($params, '/searchtext');
    //    $json = json_decode ($request['data']);
    //    
    //    $result = array();
    //    
    //    foreach ($json as $value) {
    //        $result[] = $value ->ColumnIndex;
    //    }
    //    return $result[0];
    //}    
    //function insertRow($id, $sheetName, $row){
    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //        'startindex' => $row,
    //        'count' => 1,
    //        'formatmode' => "FormatAsPrevious",
    //    );
    //    return put($params, "/insertrows");
    //}
    //function removeRow($id, $sheetName, $row){
    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //        'startindex' => $row,
    //        'count' => 1,
    //    );
    //    $request = delete($params, "/deleterows");
    //    return $request;
    //}
    //function removeColumn($id, $sheetName, $column){
    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //        'startindex' => $column,
    //        'count' => 1,
    //    );
    //    $request = delete($params, "/deletecolumns")['data'];
    //    return $request;
    //}
    //function insertColumn($id, $sheetName, $column){
    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //        'startindex' => $column,
    //        'count' => 1,
    //        'formatmode' => "FormatAsNext",
    //    );
    //    return put($params, "/insertcolumns");
    //}
    function loadDocument($filename){
        $params = array( 'filename' => $filename, );
        $request = get($params, '/loaddocument')['data'];
        return json_decode($request)->Id;
    }
    function closeDocument($filename, $id){
        $params = array( 
            'id' => $id,
            'filename' => $filename, 
            'savechanges' => TRUE,
        );

        $request = get($params, '/closedocument');
        return $request;
    }
    //function setCellValue($sheetName, $row, $column, $filename, $value, $id){
    //    $params = array(
    //    'id' => $id,
    //    'filename' => $filename,
    //    'sheetname' => $sheetName,
    //    'rowindex' => $row,
    //    'columnindex' => $column,
    //    'value' => $value,
    //    );
    //    return put($params, "/setcellvalue");
    //}
    //function updateCellsFormulas($sheetName, $column, $id) {
    //    $row=1;
    //    $user = getCellValue($id, $sheetName, $row, 0);
    //    while (!empty($user)) {
    //        $replace = '=B'.strval($row+1).'*Materials!$B$2';
    //        $formula = getCellFormula($id, $sheetName, $row, $column);
    //        if(empty($formula)) {
    //            $formula = $replace;
    //        } else {
    //            $formula = str_replace("=", $replace.'+', $formula);
    //        }
    //        setCellFormula($id, $sheetName, $row, $column, $formula);
    //        $user = getCellValue($id, $sheetName, ++$row, 0);
    //    }
    //}
    //function updateCellsFormulasAfterRemove($sheetName, $column, $id) {
    //    $row=1;
    //    $formula = getCellFormula($id, $sheetName, $row, $column);
    //    while (!empty($formula)) {
    //        $newFormula = str_replace('#REF!*Materials!#REF!', '', $formula);
    //        $newFormula = str_replace('=+', '=', $newFormula);
    //        $newFormula = str_replace('++', '+', $newFormula);
    //        if(strlen($newFormula)<4){
    //            $newFormula = '=0';
    //        }
    //        setCellFormula($id, $sheetName, $row, $column, $newFormula);
    //        $formula = getCellFormula($id, $sheetName, ++$row, $column);
    //    }
    //}
    //function setCellFormula($id, $sheetName, $row, $column, $formula){
    //    $params = array(
    //        'id' => $id,
    //        'sheetname' => $sheetName,
    //        'rowindex' => $row,
    //        'columnindex' => $column,
    //        'value' => $formula,
    //        );
    //    $request = put($params, "/setformula");
    //    return $request['data'];
    //}
    //function getCellFormula($id, $sheetName, $row, $column){
    //    $params = array(
    //    'id' => $id,
    //    'sheetname' => $sheetName,
    //    'rowindex' => $row,
    //    'columnindex' => $column,
    //    );
    //    $request = get($params, "/getformula")['data'];
    //    return json_decode($request)->Value;
    //}
    function getCellValue($id, $sheetName, $row, $column){
        $params = array(
        'id' => $id,
        'sheetname' => $sheetName,
        'rowindex' => $row,
        'columnindex' => $column,
        );
        $request = get($params, "/getcellvalue")['data'];

        return json_decode ($request)->Value;
    }
    //function createFormula($id){
    //    $formulaColumn = searchColumn(SheetNames::Users, Names::FormulaColumnName, $id);
    //    $column = 1;
    //    $formula= '=';
    //    
    //    while($column < $formulaColumn){
    //        $columnName = getColumnName($column);
    //        $row = $column+1;
    //        $formula = $formula.$columnName.'2*Materials!$B$'.$row.'+';
    //        $column++;
    //    }
    //    $formula = $formula.'0';
    //    setCellFormula($id, SheetNames::Users, 1, $formulaColumn, $formula);
    //}
    //function getColumnName($column){
    //    return substr ( Names::ColumnNames , $column, 1 );
    //}

    function delete( $params, $url ) {
        if (empty($params))
            return null;

        $json = json_encode($params);

        $header = generate_header();

        $request = curl_init();
        curl_setopt_array($request, [
            CURLOPT_URL => PrivateConst::Base_Url.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => $json
        ]);
        $response = curl_exec($request);
        $info = curl_getinfo($request);
        curl_close($request);

        return array('status' => $info['http_code'], 'data' => $response);
    }
    function put( $params, $url ) {
        if (empty($params))
            return null;

        $json = json_encode($params);

        $header = generate_header();

        $request = curl_init();
        curl_setopt_array($request, [
            CURLOPT_URL => PrivateConst::Base_Url.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => $json
        ]);
        $response = curl_exec($request);
        $info = curl_getinfo($request);
        curl_close($request);

        return array('status' => $info['http_code'], 'data' => $response);
    }
    function get( $params, $url ) {
        if ( empty( $params ) )
            return null;
        
        $header = generate_header();
        $request = curl_init();
        curl_setopt_array( $request, [
            CURLOPT_URL => PrivateConst::Base_Url.$url.'?'.http_build_query( $params ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true
        ]);

        try {
            $response = curl_exec( $request );
            $info = curl_getinfo( $request );
            curl_close( $request );
        } catch ( Exception $e ) {
            return array( 'status' => 434, 'data' => $e );
        }
        
        return array( 'status' => $info['http_code'], 'data' => $response );
    }
    function generate_header() {
        $API_key = PrivateConst::API_KEY;
        $header = [
            'Content-type: application/json',
            'Authorization: amx '.$API_key,
        ];
        return $header;
    }
?>