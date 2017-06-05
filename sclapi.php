<?php
    require_once('/privateconst.php');
    $type = $_GET['type'];
    
    if($type == Commands::GetUsersHtml)
        getUsersHtml();
    if($type == Commands::GetMaterialsHtml)
        getHtml(SheetNames::Materials, -1, -1);
    if($type == Commands::GetPrintsHtml)
        getPrintsHtml();
    if($type == Commands::CreatePrinting)
        createPrinting();
    if($type == Commands::CreateUser)
        createUser();
    if($type == Commands::ChangePrintingLength)
        changePrintingLength();
    if($type == Commands::ChangePrintingUser)
        changePrintingUser();
    if($type == Commands::ChangePrintingMaterial)
        changePrintingMaterial();
    if($type == Commands::CreateMaterial)
        createMaterial();
    if($type == Commands::ChangeUserName)
        changeUserName();
    if($type == Commands::ChangeMaterialName)
        changeMaterialName();
    if($type == Commands::ChangeMaterialPrice)
        changeMaterialPrice();
    if($type == Commands::ChangeMaterialDensity)
        changeMaterialDensity();
    if($type == Commands::ChangeMaterialDiameter)
        changeMaterialDiameter();
    if($type == Commands::GetChart)
        getChart();

    function getChart(){
        $filename = PrivateConst::File_Name;
        $id = loadDocument($filename);
        echo getImage($id);
    }
    function getPrintsHtml(){
        $filename = PrivateConst::File_Name;
        $sheetName = SheetNames::Prints;
        $id = loadDocument($filename);
        
        $firstEmptyRow = findFirstEmptyRow($id, $sheetName, 0);
        $rowLimit = $firstEmptyRow - 1;
        $result = getSessionHtml($id, $sheetName, $rowLimit, 3);
        if($result['status'] == 200){
            echo $result['data'];
        }
            //closeDocument($filename, $id);
    }
    function getUsersHtml(){
        $filename = PrivateConst::File_Name;
        $sheetName = SheetNames::Users;
        $id = loadDocument($filename);
        $firstEmptyRow = findFirstEmptyRow($id, $sheetName, 0);
        $rowLimit = $firstEmptyRow - 1;
        $result = getSessionHtml($id, $sheetName, $rowLimit, 1);
        if($result['status'] == 200){
            echo $result['data'];
        }
            //closeDocument($filename, $id);
    }
    function getHtml($sheetName, $rowLimit, $columnLimit){
        $filename = PrivateConst::File_Name;
        $id = loadDocument($filename);
        $result = getSessionHtml($id, $sheetName, $rowLimit, $columnLimit);
        if($result['status'] == 200){
            echo $result['data'];
        }
            //closeDocument($filename, $id);
    }
    function getSessionHtml($id, $sheetName, $rowLimit, $columnLimit){
        $params = array(
            'id' => $id,
            'sheetname' => $sheetName,
        );
        if($rowLimit > -1){
            $params['endrowindex'] = $rowLimit;
        }
        if($columnLimit > -1){
            $params['endcolumnindex'] = $columnLimit;
        }
        $request = get($params, '/exporttohtml');
        return $request;
    }

    function findFirstEmptyRow($id, $sheetName, $column){
        if(in_array(Names::FirstEmptyRow, $_GET)){
            return $_GET[Names::FirstEmptyRow];
        }
        $firstEmptyRow = 0;
        do{
            $userNameValue = getCellValue($id, $sheetName, ++$firstEmptyRow, $column);
        } while(!empty($userNameValue));
        return $firstEmptyRow;
    }
    function createPrinting(){
        $filename = PrivateConst::File_Name;
        $userName = $_GET[Names::NewUserName];
        $materialName = $_GET[Names::NewMaterialName];
        $length = $_GET[Names::Length];
        $id = loadDocument($filename);
        $firstEmptyRow = findFirstEmptyRow($id, SheetNames::Prints, 0);
        setCellValue(SheetNames::Prints, $firstEmptyRow, 0, $filename, $userName, $id);
        setCellValue(SheetNames::Prints, $firstEmptyRow, 1, $filename, $materialName, $id);
        setCellValue(SheetNames::Prints, $firstEmptyRow, 2, $filename, floatval($length), $id);
        $result = getSessionHtml($id, SheetNames::Prints, $firstEmptyRow, 3);
        if($result['status'] == 200){
            echo $result['data'];
        }
            closeDocument($filename, $id);
    }
    function changePrintingLength(){
        $filename = PrivateConst::File_Name;
        $row = $_GET[Names::Row];
        $value = $_GET[Names::Length];
        
        $id = loadDocument($filename);
        setCellValue(SheetNames::Prints, $row, 2, $filename, floatval($value), $id);
        $firstEmptyRow = findFirstEmptyRow($id, SheetNames::Prints, 0);
        $result = getSessionHtml($id, SheetNames::Prints, --$firstEmptyRow, 3);
        if($result['status'] == 200){
            echo $result['data'];
        }
            closeDocument($filename, $id);
    }
    function changePrintingUser(){
        $filename = PrivateConst::File_Name;
        $row = $_GET[Names::Row];
        $value = $_GET[Names::NewValue];
        
        $id = loadDocument($filename);
        setCellValue(SheetNames::Prints, $row, 0, $filename, $value, $id);
        $firstEmptyRow = findFirstEmptyRow($id, SheetNames::Prints, 0);
        $result = getSessionHtml($id, SheetNames::Prints, --$firstEmptyRow, 3);
        if($result['status'] == 200){
            echo $result['data'];
        }
            closeDocument($filename, $id);
    }
    function changePrintingMaterial(){
        $filename = PrivateConst::File_Name;
        $row = $_GET[Names::Row];
        $value = $_GET[Names::NewValue];
        
        $id = loadDocument($filename);
        setCellValue(SheetNames::Prints, $row, 1, $filename, $value, $id);
        $firstEmptyRow = findFirstEmptyRow($id, SheetNames::Prints, 0);
        $result = getSessionHtml($id, SheetNames::Prints, --$firstEmptyRow, 3);
        if($result['status'] == 200){
            echo $result['data'];
        }
            closeDocument($filename, $id);
    }

    function createUser(){
        $filename = PrivateConst::File_Name;
        $userName = $_GET[Names::NewUserName];
        $id = loadDocument($filename);
        $firstEmptyRow = findFirstEmptyRow($id, SheetNames::Users, 0);
        setCellValue(SheetNames::Users, $firstEmptyRow, 0, $filename, $userName, $id);
        $result = getSessionHtml($id, SheetNames::Users, $firstEmptyRow, 1);
        if($result['status'] == 200){
            echo $result['data'];
        }
            closeDocument($filename, $id);
    }
    function changeUserName(){
        $filename = PrivateConst::File_Name;
        $row = $_GET[Names::Row];
        $newValue = $_GET[Names::NewValue];
        $id = loadDocument($filename);
        $oldValue = getCellValue($id, SheetNames::Users, $row, 0);
        setCellValue(SheetNames::Users, $row, 0, $filename, $newValue, $id);
        $jsonPrintsCells = searchCells(SheetNames::Prints, $oldValue, 0, -1, 'TRUE', $id);
        foreach ($jsonPrintsCells as $cell) {
            setCellValue(SheetNames::Prints, $cell ->RowIndex, 0, $filename, $newValue, $id);
        }
        $firstEmptyRow = findFirstEmptyRow($id, SheetNames::Users, 0);
        $result = getSessionHtml($id, SheetNames::Users, --$firstEmptyRow, 1);
        if($result['status'] == 200){
            closeDocument($filename, $id);
        }
        echo $result['data'];
    }

    function createMaterial(){
        $filename = PrivateConst::File_Name;
        $materialName = $_GET[Names::NewMaterialName];
        $materialDensity = $_GET[Names::NewMaterialDensity];
        $materialDiameter = $_GET[Names::NewMaterialDiameter];
        $materialPrice = $_GET[Names::NewMaterialPrice];

        $id = loadDocument($filename);
        insertRow($id, SheetNames::Materials, 1);
        setCellValue(SheetNames::Materials, 1, 0, $filename, $materialName, $id);
        setCellValue(SheetNames::Materials, 1, 1, $filename, floatval($materialDensity), $id);
        setCellValue(SheetNames::Materials, 1, 2, $filename, floatval($materialDiameter), $id);
        setCellValue(SheetNames::Materials, 1, 3, $filename, floatval($materialPrice), $id);
        $result = getSessionHtml($id, SheetNames::Materials, -1, -1);
        if($result['status'] == 200){
            closeDocument($filename, $id);
        }
        echo $result['data'];
    }
    function changeMaterialName(){
        $filename = PrivateConst::File_Name;
        $row = $_GET[Names::Row];
        $value = $_GET[Names::NewValue];
        
        $id = loadDocument($filename);
        $oldValue = getCellValue($id, SheetNames::Materials, $row, 0);
        setCellValue(SheetNames::Materials, $row, 0, $filename, $value, $id);
        $jsonPrintsCells = searchCells(SheetNames::Prints, $oldValue, 1, -1, 'TRUE', $id);
        foreach ($jsonPrintsCells as $cell) {
            setCellValue(SheetNames::Prints, $cell ->RowIndex, 1, $filename, $value, $id);
        }
        $result = getSessionHtml($id, SheetNames::Materials, -1, -1);
        closeDocument($filename, $id);

        echo $result;
    }
    function changeMaterialDensity(){
        echo changeMaterialValue(1);
    }
    function changeMaterialDiameter(){
        echo changeMaterialValue(2);
    }
    function changeMaterialPrice(){
        echo changeMaterialValue(3);
    }
    function changeMaterialValue($column){
        $filename = PrivateConst::File_Name;
        $row = $_GET[Names::Row];
        $value = $_GET[Names::NewValue];
        
        $id = loadDocument($filename);
        setCellValue(SheetNames::Materials, $row, $column, $filename, floatval($value), $id);
        $result = getSessionHtml($id, SheetNames::Materials, -1, -1);
        closeDocument($filename, $id);

        return $result;
    }
        
    function getImage($id){
        $request = getPictureBytes($id);
        if($request['status'] == 200){
            $imgJSON = $request['data'];
            $response = json_decode( $imgJSON, true );
            $imgBytes = $response[0]['PictureBytes'];
            return 'data:image/jpeg;base64,'.$imgBytes;
        }
        return '<span>Sorry, we has problem on service. But we know about it.</span>';
    }
    function getPictureBytes($id) {
        $params = array(
            'id' => $id,
            'sheetname' => SheetNames::Charts,
            'picturetype' => 'Chart',
            'startrowindex' => 0,
            'startcolumnindex' => 0,
            'endrowindex' => 19,
            'endcolumnindex' => 7,
            'objectindex' => 0,
            'scale' => 0.2
        );
        return get( $params, '/getpictures' );
    }
    function searchCells($sheetName, $text, $column, $row, $matchCase, $id){
        $params = array(
            'id' => $id,
            'sheetname' => $sheetName,
            'text' => $text,
            'matchentirecellcontents' => 'TRUE',
            'matchcase' => $matchCase,
        );
        if($column > -1){
            $params['startcolumnindex'] = $column;
            $params['endcolumnindex'] = $column;
        }
        if($row > -1){
            $params['startrowindex'] = $row;
            $params['endrowindex'] = $row;
        }
        $request = get($params, '/searchtext');
        $json = json_decode ($request['data']);
        return $json;
    }
    function insertRow($id, $sheetName, $row){
        $params = array(
            'id' => $id,
            'sheetname' => $sheetName,
            'startindex' => $row,
            'count' => 1,
            'formatmode' => "FormatAsPrevious",
        );
        return put($params, "/insertrows");
    }
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
    function setCellValue($sheetName, $row, $column, $filename, $value, $id){
        $params = array(
        'id' => $id,
        'filename' => $filename,
        'sheetname' => $sheetName,
        'rowindex' => $row,
        'columnindex' => $column,
        'value' => $value,
        );
        return put($params, "/setcellvalue");
    }
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