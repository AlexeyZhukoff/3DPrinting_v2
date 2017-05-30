<?php
class PrivateConst {
     //const Base_Url = 'http://spreadsheetcloudapi.azurewebsites.net/api/spreadsheet';
     const Base_Url = 'http://localhost:54306/api/spreadsheet';
     const API_KEY = '87b1e9521ecef9e65d183b62fa157276';
     const File_Name = '3D_v2.xlsx';
}
class SheetNames {
     const Users = 'Users';
     const Materials = 'Materials';
//     const Charts = 'Charts';
}
//class Names {
//    const FormulaColumnName = 'Full Price';
//    const ColumnNames = 'ABCDEFGHIGKLMNOPQRSTUVWXYZ';
//    const NewUserName = 'newUserName';
//    const NewMaterialName = 'newMaterialName';
//    const NewMaterialPrice = 'newMaterialPrice';
//    const NewMaterialDensity = 'newMaterialDensity';
//    const NewMaterialDiameter = 'newMaterialDiameter';

//    const UserName = 'userName';
//    const MaterialName = 'materialName';
//    const Row = 'row';
//    const Column = 'column';
//    const NewValue = 'newValue';
//}
class Commands {
//    const CreateUser = 'createUser';
//    const RemoveUser = 'removeUser';
//    const CreateMaterial = 'createMaterial';
//    const RemoveMaterial = 'removeMaterial';
    const GetUsersHtml = 'getUsersHtml';
    const GetMaterialsHtml = 'getMaterialsHtml';
//    const ChangeUsersValue = 'changeUsersValue';
//    const ChangeMaterialName = 'changeMaterialName';
//    const ChangeMaterialPrice = 'changeMaterialPrice';
//    const ChangeMaterialDensity = 'changeMaterialDensity';
//    const ChangeMaterialDiameter = 'changeMaterialDiameter';
}
?>