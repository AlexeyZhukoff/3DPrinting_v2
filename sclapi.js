$(document).ready(function () {
    loadDocument();
    loadChart();

    //#region HTML Export
    function loadUsers() {
        $.get('sclapi.php', { type: 'getUsersHtml' }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("usersList").innerHTML = data;
            loadChart();
        }
    }
    function loadMaterials() {
        $.get('sclapi.php', { type: 'getMaterialsHtml' }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("materials").innerHTML = data;
        }
    }
    function loadPrints() {
        $.get('sclapi.php', { type: 'getPrintsHtml' }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("printsList").innerHTML = data;
            $('.addUserButton').attr("style", "");
            $('.addMaterialButton').attr("style", "");
            $('.addPrintButton').attr("style", "");
        }
    }
    function loadChart() {
        $.get('sclapi.php', { type: 'getChart' }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            $("#chartImage").attr('src', data);
            $("#chartImage").attr('style', '');
        }
    }
    function loadDocument() {
        $('.addUserButton').attr("style", "display: none");
        $('.addMaterialButton').attr("style", "display: none");
        $('.addPrintButton').attr("style", "display: none");
        $.get('sclapi.php', { type: 'getDocument' }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            var dataArr = $.parseJSON(data);
            document.getElementById("printsList").innerHTML = dataArr.Prints;
            document.getElementById("usersList").innerHTML = dataArr.Users;
            document.getElementById("materials").innerHTML = dataArr.Materials;
            $('.addUserButton').attr("style", "");
            $('.addMaterialButton').attr("style", "");
            $('.addPrintButton').attr("style", "");
        }
    }
    //#endregion HTML Export

    //#region PrintsList
    $('body').on('click', '.addPrintButton', function () {
        ShowNewPrintingDialog();
    })
    $('body').on('click', '.cancelPButton', function () {
        HideNewPrintingDialog();
    })
    $('body').on('click', '.createPButton', function () {
        CreatePrinting($('#printingUser').val(), $('#usedMaterial').val(), $('#materialLength').val());
    })
    $('#materialLength').keyup(function (e) {
        if (e.keyCode == 13) {
            $('.createPButton').click();
        }
    })
    $('body').on('change', '.changePrintingUser', function () {
        row = $(this).data('row');
        newvalue = $(this).val();
        oldvalue = $(this).attr('oldvalue');
        if (newvalue != oldvalue) {
            changePrintingUser(newvalue, row);
        }
    })
    $('body').on('change', '.changePrintingMaterial', function () {
        row = $(this).data('row');
        newvalue = $(this).val();
        oldvalue = $(this).attr('oldvalue');
        if (newvalue != oldvalue) {
            changePrintingMaterial(newvalue, row);
        }
    })
    $('body').on('change', '.changePrintsVal', function () {
        row = $(this).data('row');
        newvalue = $(this).val();
        oldvalue = $(this).attr('oldvalue');
        if (newvalue != oldvalue) {
            if (isNaN(newvalue) || 0 === newvalue.length) {
                alert('Sorry, "Length of used material" must be a number!');
                return;
            } else {
                ChangePrintingLength(newvalue, row);
            }
        }
    })
    $('body').on('blur', '.changePrintingMaterial', function () {
        var oldvalue = $(this).attr('oldvalue');
        var td = $(this).parent();
        $(this).remove();
        td.text(oldvalue);
    })
    $('body').on('blur', '.changePrintingUser', function () {
        var oldvalue = $(this).attr('oldvalue');
        var td = $(this).parent();
        $(this).remove();
        td.text(oldvalue);
    })
    $('body').on('blur', '.changePrintsVal', function () {
        var oldvalue = $(this).attr('oldvalue');
        var td = $(this).parent();
        $(this).remove();
        td.text(oldvalue);
    })
    function CreatePrinting(username, materialname, length) {
        if (isNaN(length) || 0 === length.length) {
            alert('Sorry, "Length of used material" must be a number!');
            return;
        }
        if (!username || 0 === username.length) {
            alert('Please create "User" to may select!');
            return;
        }
        if (!materialname || 0 === materialname.length) {
            alert('Please create "Material" to may select!');
            return;
        }
        CreatePrintingHtml(username, materialname, length);
        $.get('sclapi.php', { type: 'createPrinting', newUserName: username, newMaterialName: materialname, length: length, firstEmptyRow: GetRowsCount("#printsList") - 2 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("printsList").innerHTML = data;
            loadUsers();
        }
        HideNewPrintingDialog();
    }
    function CreatePrintingHtml(username, materialname, length) {
        var tbody = $("#printsList").find("tbody")[0];
        var outerHTML = '<tr><td></td><td></td><td></td><td></td></tr>';
        if (tbody.rows.length > 2)
            outerHTML = tbody.children[tbody.rows.length - 1].outerHTML;
        tbody.insertRow(tbody.rows.length).outerHTML = outerHTML;

        var newRow = tbody.children[tbody.rows.length - 1];
        newRow.children[0].innerText = username;
        newRow.children[1].innerText = materialname;
        newRow.children[2].innerText = length;
        newRow.children[3].innerText = 'calculating';
    }
    function ShowNewPrintingDialog() {
        $('#newPrintingDialog').attr("style", "");
        document.getElementById("printingUser").innerHTML = GetUsers();
        document.getElementById("usedMaterial").innerHTML = GetMaterials();
        $('#materialLength').val('');
        $('.addPrintButton').attr("style", "display: none");
    }
    function HideNewPrintingDialog() {
        $('#newPrintingDialog').attr("style", "display: none");
        $('.addPrintButton').attr("style", "");
    }
    function PrintsTableClick(td, row, col) {
        if (col > 2)
            return;
        if (col == 0) {
            CreateInnerSelector(td, "changePrintingUser", row, col, GetUsersOptions());
        }
        if (col == 1) {
            CreateInnerSelector(td, "changePrintingMaterial", row, col, GetMaterialsOptions());
        }
        if (col == 2) {
            CreateInnerInput(td, "changePrintsVal", row, col, '');
        }
        HideNewPrintingDialog();
    }
    function changePrintingUser(newvalue, row) {
        $.get('sclapi.php', { type: 'changePrintingUser', row: row, newValue: newvalue, firstEmptyRow: GetRowsCount("#printsList") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("printsList").innerHTML = data;
            loadUsers();
        }
    }
    function changePrintingMaterial(newvalue, row) {
        $.get('sclapi.php', { type: 'changePrintingMaterial', row: row, newValue: newvalue, firstEmptyRow: GetRowsCount("#printsList") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("printsList").innerHTML = data;
            loadUsers();
        }
    }
    function ChangePrintingLength(newvalue, row) {
        $.get('sclapi.php', { type: 'changePrintingLength', row: row, length: newvalue, firstEmptyRow: GetRowsCount("#printsList") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("printsList").innerHTML = data;
            loadUsers();
        }
    }
    //#endregion PrintsList

    //#region UsersList
    $('body').on('click', '.addUserButton', function () {
        ShowNewUserDialog();
    })
    $('body').on('click', '.createButton', function () {
        CreateUser($('#newUserName').val());
    })
    $('#newUserName').keyup(function (e) {
        if (e.keyCode == 13) {
            CreateUser($('#newUserName').val());
        }
    })
    $('body').on('click', '.cancelButton', function () {
        HideNewUserDialog();
    })
    $('body').on('change', '.changeUserVal', function () {
        row = $(this).data('row');
        col = $(this).data('column');
        newvalue = $(this).val();
        oldvalue = $(this).attr('oldvalue');
        if (newvalue != oldvalue && col == 0) {
            if (!newvalue || 0 === newvalue.length) {
                //RemoveUser(oldvalue);
            } else {
                if (HaveUserName(newvalue)) {
                    alert('User with this name already exists!');
                    return;
                }
                ChangeUserName(newvalue, row);
            }
        }
    })
    $('body').on('blur', '.changeUserVal', function () {
        var oldvalue = $(this).attr('oldvalue');
        var td = $(this).parent();
        $(this).remove();
        td.text(oldvalue);
    })
    function CreateUser(username) {
        if (HaveUserName(username)) {
            alert('User with this name already exists!');
            return;
        }
        HideNewUserDialog();
        if (!username || 0 === username.length)
            return;
        CreateUserHtml(username);
        $.get('sclapi.php', { type: 'createUser', newUserName: username, firstEmptyRow: GetRowsCount("#usersList") - 2 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("usersList").innerHTML = data;
            loadChart();
        }
    }
    function CreateUserHtml(username) {
        var tbody = $("#usersList").find("tbody")[0];
        var outerHTML = '<tr><td></td><td></td></tr>';
        if (tbody.rows.length > 2)
            outerHTML = tbody.children[tbody.rows.length - 1].outerHTML;
        tbody.insertRow(tbody.rows.length).outerHTML = outerHTML;

        var newRow = tbody.children[tbody.rows.length - 1];
        newRow.children[0].innerText = username;
        newRow.children[1].innerText = 0;
    }
    function UsersTableClick(td, row, col) {
        CreateInnerInput(td, "changeUserVal", row, col, '');
        HideNewUserDialog();
    }
    function ShowNewUserDialog() {
        $('#newUserDialog').attr("style", "");
        $('#newUserName').val('');
        $('.addUserButton').attr("style", "display: none");
    }
    function HideNewUserDialog() {
        $('#newUserDialog').attr("style", "display: none");
        $('.addUserButton').attr("style", "");
    }
    function ChangeUserName(newvalue, row) {
        $.get('sclapi.php', { type: 'changeUserName', row: row, newValue: newvalue, firstEmptyRow: GetRowsCount("#usersList") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("usersList").innerHTML = data;
            loadChart();
        }
    }
    function HaveUserName(username) {
        var result = false;
        $('#usersList').find('td').each(function () {
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
            if (col == 0 && row > 1 && $(this).text() == username) {
                result = true;
                return false;
            }
        });
        return result;
    }
    function GetUsers() {
        var result = '<select id="printingUser">';
        result = result + GetUsersOptions();
        result = result + '</select>';
        return result;
    }
    function GetUsersOptions() {
        var result = '';
        $('#usersList').find('td').each(function () {
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
            if (col == 0 && row > 1) {
                result = result + '<option>' + $(this).text() + '</option>';
            }
        });
        return result;
    }
    //#endregion UsersList

    //#region MaterialsList
    $('body').on('click', '.addMaterialButton', function () {
        ShowNewMaterialDialog();
    })
    $('body').on('click', '.createMButton', function () {
        CreateMaterial();
    })
    $('body').on('click', '.cancelMButton', function () {
        HideNewMaterialDialog();
    })
    $('body').on('change', '.changeMaterialsVal', function () {
        row = $(this).data('row');
        col = $(this).data('column');
        newvalue = $(this).val();
        oldvalue = $(this).attr('oldvalue');
        if (newvalue != oldvalue) {
            if (col == 0) {
                if (!newvalue || 0 === newvalue.length) {
                    //                    RemoveMaterial(oldvalue);
                } else {
                    if (HaveMaterialName(newvalue)) {
                        alert('Material with this name already exists!');
                        return;
                    }
                    ChangeMaterialName(row, newvalue);
                }
            } else {
                if (isNaN(newvalue) || !newvalue || 0 === newvalue.length) {
                    $(this).css("border-color", "red");
                    alert('Sorry, value must be a number!');
                    return;
                }
                if (col == 1) {
                    ChangeMaterialDensity(row, newvalue);
                }
                if (col == 2) {
                    ChangeMaterialDiameter(row, newvalue);
                }
                if (col == 3) {
                    ChangeMaterialPrice(row, newvalue);
                }
            }
        }
    })
    $('body').on('blur', '.changeMaterialsVal', function () {
        var oldvalue = $(this).attr('oldvalue');
        var col = $(this).data('column');
        var td = $(this).parent();
        $(this).remove();
        if (col == 3) {
            oldvalue = '$' + oldvalue;
        }
        td.text(oldvalue);
    })
    $('#newMaterialName').keyup(function (e) {
        if (e.keyCode == 13) {
            $('.createMButton').click();
        }
    })
    $('#newMaterialDensity').keyup(function (e) {
        if (e.keyCode == 13) {
            $('.createMButton').click();
        }
    })
    $('#newMaterialDiameter').keyup(function (e) {
        if (e.keyCode == 13) {
            $('.createMButton').click();
        }
    })
    $('#newMaterialPrice').keyup(function (e) {
        if (e.keyCode == 13) {
            $('.createMButton').click();
        }
    })
    function CreateMaterial() {
        var materialname = $('#newMaterialName').val();
        var materialprice = $('#newMaterialPrice').val();
        var materialdensity = $('#newMaterialDensity').val();
        var materialdiameter = $('#newMaterialDiameter').val();
        if (materialdiameter == "" || isNaN(materialdiameter)) {
            alert('Sorry, "Material diameter" must be a number!');
            return;
        }
        if (materialdensity == "" || isNaN(materialdensity)) {
            alert('Sorry, "Material density" must be a number!');
            return;
        }
        if (materialprice == "" || isNaN(materialprice)) {
            alert('Sorry, "Material price" must be a number!');
            return;
        }
        if (!materialname || 0 === materialname.length) {
            alert('Sorry, "Material name" must be a not empty!');
            return;
        }
        if (HaveMaterialName(materialname)) {
            alert('Material with this name already exists!');
            return;
        }
        HideNewMaterialDialog();
        CreateMaterialHtml(materialname, materialprice, materialdensity, materialdiameter);
        $.get('sclapi.php', { type: 'createMaterial', newMaterialName: materialname, newMaterialPrice: materialprice, newMaterialDensity: materialdensity, newMaterialDiameter: materialdiameter }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("materials").innerHTML = data;
        }
    }
    function CreateMaterialHtml(materialname, materialprice, materialdensity, materialdiameter) {
        var tbody = $("#materials").find("tbody")[0];
        var outerHTML = '<tr><td></td><td></td><td></td><td></td></tr>';
        if (tbody.rows.length > 2)
            outerHTML = tbody.children[2].outerHTML;
        tbody.insertRow(2).outerHTML = outerHTML;

        var newRow = tbody.children[2];
        newRow.children[0].innerText = materialname;
        newRow.children[1].innerText = materialdensity;
        newRow.children[2].innerText = materialdiameter;
        newRow.children[3].innerText = materialprice;
    }
    function MaterialsTableClick(td, row, col) {
        var value = '';
        if (col == 3) {
            value = td.text();
            value = value.replace('$', '');
        }
        CreateInnerInput(td, "changeMaterialsVal", row, col, value);
        HideNewMaterialDialog();
    }
    function ChangeMaterialName(row, newvalue) {
        $.get('sclapi.php', { type: 'changeMaterialName', row: row, newValue: newvalue, firstEmptyRow: GetRowsCount("#materials") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("materials").innerHTML = data;
        }
    }
    function ChangeMaterialPrice(row, newvalue) {
        $.get('sclapi.php', { type: 'changeMaterialPrice', row: row, newValue: newvalue, firstEmptyRow: GetRowsCount("#materials") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("materials").innerHTML = data;
        }
    }
    function ChangeMaterialDensity(row, newvalue) {
        $.get('sclapi.php', { type: 'changeMaterialDensity', row: row, newValue: newvalue, firstEmptyRow: GetRowsCount("#materials") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("materials").innerHTML = data;
        }
    }
    function ChangeMaterialDiameter(row, newvalue) {
        $.get('sclapi.php', { type: 'changeMaterialDiameter', row: row, newValue: newvalue, firstEmptyRow: GetRowsCount("#materials") - 1 }, onAjaxSuccess);
        function onAjaxSuccess(data) {
            document.getElementById("materials").innerHTML = data;
        }
    }
    function ShowNewMaterialDialog() {
        $('#newMaterialDialog').attr("style", "");
        $('#newMaterialName').val('');
        $('#newMaterialDensity').val('');
        $('#newMaterialDiameter').val('');
        $('#newMaterialPrice').val('');
        $('.addMaterialButton').attr("style", "display: none");
    }
    function HideNewMaterialDialog() {
        $('#newMaterialDialog').attr("style", "display: none");
        $('.addMaterialButton').attr("style", "");
    }
    function HaveMaterialName(materialname) {
        var result = false;
        $('#materials').find('td').each(function () {
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
            if (col == 0 && row > 1 && $(this).text() == materialname) {
                result = true;
                return false;
            }
        });
        return result;
    }
    function GetMaterials() {
        var result = '<select id="usedMaterial">';
        result = result + GetMaterialsOptions();
        result = result + '</select>';
        return result;
    }
    function GetMaterialsOptions() {
        var result = '';
        $('#materials').find('td').each(function () {
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());
            if (col == 0 && row > 1) {
                result = result + '<option>' + $(this).text() + '</option>';
            }
        });
        return result;
    }
    //#endregion MaterialsList

    //#region Interface
    $('.tabs .tab-links a').on('click', function (e) {
        HideNewPrintingDialog();
        HideNewUserDialog();
        HideNewMaterialDialog();
        var currentAttrValue = $(this).attr('href');
        $('.tabs ' + currentAttrValue).show().siblings().hide();
        $(this).parent('li').addClass('active').siblings().removeClass('active');
        e.preventDefault();
        $("#usersChart").show();
    });
    $('body').on('click', 'td', function () {
        if ($(this).children().length > 0)
            return;
        var parentDiv = $(this).closest('div');
        var col = $(this).parent().children().index($(this));
        var lastcol = $(this).parent().children().length - 1;
        var row = $(this).parent().parent().children().index($(this).parent());
        var divid = parentDiv.attr('id');
        if (row > 1) {
            if (divid == 'usersList' && col != lastcol)
                UsersTableClick($(this), row - 1, col);
            if (divid == 'materials')
                MaterialsTableClick($(this), row - 1, col);
            if (divid == 'printsList')
                PrintsTableClick($(this), row - 1, col);
        }
    })
    function CreateInnerInput(td, name, row, col, value) {
        if (!value || 0 === value.length) {
            value = td.text();
        }
        var width = $(td).width() - 5;
        var height = $(td).parent().height() - 8;
        var input = '<input class="' + name + '" name="' + name + '" value="' + value + '" oldvalue="' + value + '" style="width:' + parseInt(width) + 'px; height: ' + parseInt(height) + 'px; " type="text" data-row="' + row + '" data-column="' + col + '" />';
        $(td).html('');
        $(td).append($(input));
        $(td).find('input').focus();
    }
    function CreateInnerSelector(td, name, row, col, options) {
        var width = $(td).width() - 15;
        var height = $(td).parent().height() - 2;
        var defaultValue = td.text();
        var selector = '<select selected="selected"' + 'class="' + name + '" id="' + name + '" oldvalue="' + td.text() + '" style="width:' + parseInt(width) + 'px; height: ' + parseInt(height) + 'px; " type="text" data-row="' + row + '" data-column="' + col + '">'; ;
        selector = selector + options;
        selector = selector + '</select>';
        $(td).html('');
        $(td).append($(selector));
        document.getElementById(name).value = defaultValue;
        $(td).find('select').focus();
    }
    function GetRowsCount(containerName) {
        return $(containerName).find('table')[0].rows.length;
    }
    //#endregion Interface
});