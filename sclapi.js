//$(document).ready(function () {
//    loadUsers();
//    loadMaterials();

//    //#region HTML Export
//    function loadUsers() {
//        $.get('sclapi.php', { type: 'getUsersHtml' }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//    }
//    function loadMaterials() {
//        $.get('sclapi.php', { type: 'getMaterialsHtml' }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("materials").innerHTML = data;
//        }
//    }
//    //#endregion HTML Export

//    //#region UsersList
//    $('body').on('click', '.addUserButton', function () {
//        ShowNewUserDialog();
//    })
//    $('body').on('click', '.createButton', function () {
//        CreateUser($('#newUserName').val());
//    })
//    $('#newUserName').keyup(function (e) {
//        if (e.keyCode == 13) {
//            CreateUser($('#newUserName').val());
//        }
//    })
//    $('body').on('click', '.cancelButton', function () {
//        HideNewUserDialog();
//    })
//    $('body').on('change', '.changeUserVal', function () {
//        row = $(this).data('row');
//        col = $(this).data('column');
//        newvalue = $(this).val();
//        oldvalue = $(this).attr('oldvalue');
//        if (newvalue != oldvalue) {
//            if (col != 0 && isNaN(newvalue)) {
//                $(this).css("border-color", "red");
//                alert('Sorry, value must be a number!');
//                return;
//            }
//            if (col == 0) {
//                if (!newvalue || 0 === newvalue.length) {
//                    RemoveUser(oldvalue);
//                } else {
//                    if (HaveUserName(newvalue)) {
//                        alert('User with this name already exists!');
//                        return;
//                    }
//                    ChangeUserValue(newvalue, row, col);
//                }
//                return;
//            }
//            ChangeUserValue(newvalue, row, col);
//        }
//    })
//    $('body').on('blur', '.changeUserVal', function () {
//        var oldvalue = $(this).attr('oldvalue');
//        var td = $(this).parent();
//        $(this).remove();
//        td.text(oldvalue);
//    })

//    function CreateUser(username) {
//        if (HaveUserName(username)) {
//            alert('User with this name already exists!');
//            return;
//        }
//        HideNewUserDialog();
//        if (!username || 0 === username.length)
//            return;
//        $.get('sclapi.php', { type: 'createUser', newUserName: username }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//        loadMaterials();
//    }
//    function RemoveUser(username) {
//        $.get('sclapi.php', { type: 'removeUser', userName: username }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//        loadMaterials();
//    }
//    function UsersTableClick(td, row, col) {
//        CreateInnerInput(td, "changeUserVal", row, col);
//        HideNewUserDialog();
//    }
//    function ShowNewUserDialog() {
//        $('#newUserDialog').attr("style", "");
//        $('#newUserName').val('');
//        $('.addUserButton').attr("style", "display: none");
//    }
//    function HideNewUserDialog() {
//        $('#newUserDialog').attr("style", "display: none");
//        $('.addUserButton').attr("style", "");
//    }
//    function ChangeUserValue(newvalue, row, col) {
//        $.get('sclapi.php', { type: 'changeUsersValue', row: row, column: col, newValue: newvalue }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//    }
//    function HaveUserName(username) {
//        var result = false;
//        $('#usersList').find('td').each(function () {
//            var col = $(this).parent().children().index($(this));
//            var row = $(this).parent().parent().children().index($(this).parent());
//            if (col == 0 && row > 1 && $(this).text() == username) {
//                result = true;
//                return false;
//            }
//        });
//        return result;
//    }
//    //#endregion UsersList

//    //#region MaterialsList
//    $('body').on('click', '.addMaterialButton', function () {
//        ShowNewMaterialDialog();
//    })
//    $('body').on('click', '.createMButton', function () {
//        var materialname = $('#newMaterialName').val();
//        var materialprice = $('#newMaterialPrice').val();
//        var materialdensity = $('#newMaterialDensity').val();
//        var materialdiameter = $('#newMaterialDiameter').val();

//        if (materialdiameter == "" || isNaN(materialdiameter)) {
//            alert('Sorry, "Material diameter" must be a number!');
//            return;
//        }
//        if (materialdensity == "" || isNaN(materialdensity)) {
//            alert('Sorry, "Material density" must be a number!');
//            return;
//        }
//        if (materialprice == "" || isNaN(materialprice)) {
//            alert('Sorry, "Material price" must be a number!');
//            return;
//        }
//        if (HaveMaterialName(materialname)) {
//            alert('Material with this name already exists!');
//            return;
//        }
//        HideNewMaterialDialog();
//        if (!materialname || 0 === materialname.length)
//            return;
//        $.get('sclapi.php', { type: 'createMaterial', newMaterialName: materialname, newMaterialPrice: materialprice, newMaterialDensity: materialdensity, newMaterialDiameter: materialdiameter }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//        loadMaterials();
//    })
//    $('body').on('click', '.cancelMButton', function () {
//        HideNewMaterialDialog();
//    })
//    $('body').on('change', '.changeMaterialsVal', function () {
//        row = $(this).data('row');
//        col = $(this).data('column');
//        newvalue = $(this).val();
//        oldvalue = $(this).attr('oldvalue');
//        if (newvalue != oldvalue) {
//            if (col == 0) {
//                if (!newvalue || 0 === newvalue.length) {
//                    RemoveMaterial(oldvalue);
//                } else {
//                    if (HaveMaterialName(newvalue)) {
//                        alert('Material with this name already exists!');
//                        return;
//                    }
//                    ChangeMaterialName(row, newvalue);
//                }
//            } else {
//                if (isNaN(newvalue)) {
//                    $(this).css("border-color", "red");
//                    alert('Sorry, value must be a number!');
//                    return;
//                }
//                if (col == 3) {
//                    ChangeMaterialPrice(row, newvalue);
//                }
//                //if (col == 1) {
//                //    ChangeMaterialPrice(row, newvalue);
//                //}

//            }
//        }
//    })
//    $('body').on('blur', '.changeMaterialsVal', function () {
//        var oldvalue = $(this).attr('oldvalue');
//        var td = $(this).parent();
//        $(this).remove();
//        td.text(oldvalue);
//    })
//    $('#newMaterialName').keyup(function (e) {
//        if (e.keyCode == 13) {
//            $('.createMButton').click();
//        }
//    })
//    $('#newMaterialPrice').keyup(function (e) {
//        if (e.keyCode == 13) {
//            $('.createMButton').click();
//        }
//    })
//    function MaterialsTableClick(td, row, col) {
//        CreateInnerInput(td, "changeMaterialsVal", row, col);
//        HideNewMaterialDialog();
//    }
//    function RemoveMaterial(materialname) {
//        $.get('sclapi.php', { type: 'removeMaterial', materialName: materialname }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("materials").innerHTML = data;
//        }
//        loadUsers();
//    }
//    function ChangeMaterialName(row, newvalue) {
//        $.get('sclapi.php', { type: 'changeMaterialName', row: row, newValue: newvalue }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("materials").innerHTML = data;
//        }
//        loadUsers();
//    }
//    function ChangeMaterialPrice(row, newvalue) {
//        $.get('sclapi.php', { type: 'changeMaterialPrice', row: row, newValue: newvalue }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//        loadMaterials();
//    }
//    function ChangeMaterialDensity(row, newvalue) {
//        $.get('sclapi.php', { type: 'changeMaterialDensity', row: row, newValue: newvalue }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//        loadMaterials();
//    }
//    function ChangeMaterialDiameter(row, newvalue) {
//        $.get('sclapi.php', { type: 'changeMaterialDiameter', row: row, newValue: newvalue }, onAjaxSuccess);
//        function onAjaxSuccess(data) {
//            document.getElementById("usersList").innerHTML = data;
//        }
//        loadMaterials();
//    }
//    function ShowNewMaterialDialog() {
//        $('#newMaterialDialog').attr("style", "");
//        $('#newMaterialName').val('');
//        $('#newMaterialDensity').val('');
//        $('#newMaterialDiameter').val('');
//        $('#newMaterialPrice').val('');
//        $('.addMaterialButton').attr("style", "display: none");
//    }
//    function HideNewMaterialDialog() {
//        $('#newMaterialDialog').attr("style", "display: none");
//        $('.addMaterialButton').attr("style", "");
//    }
//    function HaveMaterialName(materialname) {
//        var result = false;
//        $('#materials').find('td').each(function () {
//            var col = $(this).parent().children().index($(this));
//            var row = $(this).parent().parent().children().index($(this).parent());
//            if (col == 0 && row > 1 && $(this).text() == materialname) {
//                result = true;
//                return false;
//            }
//        });
//        return result;
//    }
//    //#endregion MaterialsList

//    //#region Interface
//    $('.tabs .tab-links a').on('click', function (e) {
//        HideNewUserDialog();
//        HideNewMaterialDialog();
//        var currentAttrValue = $(this).attr('href');
//        $('.tabs ' + currentAttrValue).show().siblings().hide();
//        $(this).parent('li').addClass('active').siblings().removeClass('active');
//        e.preventDefault();
//    });
//    $('body').on('click', 'td', function () {
//        if ($(this).children().length > 0)
//            return;
//        var parentDiv = $(this).closest('div');
//        var col = $(this).parent().children().index($(this));
//        var lastcol = $(this).parent().children().length - 1;
//        var row = $(this).parent().parent().children().index($(this).parent());
//        var divid = parentDiv.attr('id');
//        if (row > 1) {
//            if (divid == 'usersList' && col != lastcol)
//                UsersTableClick($(this), row - 1, col);
//            if (divid == 'materials')
//                MaterialsTableClick($(this), row - 1, col);
//        }
//    })
//    function CreateInnerInput(td, name, row, col) {
//        var width = $(td).width() - 5;
//        var height = $(td).parent().height() - 8;
//        var input = '<input class="' + name + '" name="' + name + '" value="' + td.text() + '" oldvalue="' + td.text() + '" style="width:' + parseInt(width) + 'px; height: ' + parseInt(height) + 'px; " type="text" data-row="' + row + '" data-column="' + col + '" />';
//        $(td).html('');
//        $(td).append($(input));
//        $(td).find('input').focus();
//    }
//    //#endregion Interface
//});