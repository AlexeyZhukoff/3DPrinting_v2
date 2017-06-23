<?php
class PrivateConst {
     const Base_Url = 'http://spreadsheetcloudapi.azurewebsites.net/api/spreadsheet';
     //const Base_Url = 'http://localhost:54306/api/spreadsheet';
     const API_KEY = '87b1e9521ecef9e65d183b62fa157276';
     const File_Name = '3D_v2.xlsx';
}
class SheetNames {
     const Users = 'Users';
     const Materials = 'Materials';
     const Prints = 'Prints';
     const Chart = 'Chart';
}
class Names {
    const NewUserName = 'newUserName';
    const NewMaterialName = 'newMaterialName';
    const NewMaterialPrice = 'newMaterialPrice';
    const NewMaterialDensity = 'newMaterialDensity';
    const NewMaterialDiameter = 'newMaterialDiameter';
    const Row = 'row';
    const NewValue = 'newValue';
    const Length = 'length';
    const FirstEmptyRow = 'firstEmptyRow';
}
class Commands {
    const CreatePrinting = 'createPrinting';
    const CreateUser = 'createUser';
    const CreateMaterial = 'createMaterial';
    const GetPrintsHtml = 'getPrintsHtml';
    const GetUsersHtml = 'getUsersHtml';
    const GetMaterialsHtml = 'getMaterialsHtml';
    const GetDocument = 'getDocument';
    const GetChart = 'getChart';
    const ChangeUserName = 'changeUserName';
    const ChangeMaterialName = 'changeMaterialName';
    const ChangeMaterialPrice = 'changeMaterialPrice';
    const ChangeMaterialDensity = 'changeMaterialDensity';
    const ChangeMaterialDiameter = 'changeMaterialDiameter';
    const ChangePrintingLength = 'changePrintingLength';
    const ChangePrintingUser = 'changePrintingUser';
    const ChangePrintingMaterial = 'changePrintingMaterial';
}
?>