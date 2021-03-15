const proxyUrl = 'https://cors-anywhere.herokuapp.com/';

var modal = document.querySelector('.modal');
if (modal) {
    $('#createBtn').on('click', function () {
        $('#regions').prop('selectedIndex',0);
        $('#groups').prop('selectedIndex',0);
        $('#types').prop('selectedIndex',0);
        $('#message-text').val("");
    })
    //загрузка регионов

    function loadRegions() {
        return new Promise (function (resolve, reject) {
            fetch(proxyUrl + 'https://pos.gosuslugi.ru/filters')
                .then(response => response.json())
                .then(regions => {
                    resolve(regions);
                })
        })
    }

    loadRegions().then(regions => {
        const defaultOption = document.createElement('option');
        defaultOption.innerHTML = 'Выберите регион';

        const selectRegions = document.querySelector('#regions');
        selectRegions.appendChild(defaultOption);

        regions.forEach(function (region) {
            const option = document.createElement('option');
            option.value = region.name;
            option.id = region.id;
            option.innerHTML = region.name;
            selectRegions.appendChild(option);
        });
    });

//загрузка групп

    function loadGroups() {
        return new Promise (function (resolve, reject) {
            fetch(proxyUrl + 'https://pos.gosuslugi.ru/inbox-service/subjects')
                .then(response => response.json())
                .then(groups => {
                    resolve(groups);
                })
        })
    }

    loadGroups().then(groups => {
        const defaultOption = document.createElement('option');
        defaultOption.innerHTML = 'Выберите группу';

        const selectGroups = document.querySelector('#groups');
        selectGroups.appendChild(defaultOption);

        groups.content.forEach(function (group) {
            const option = document.createElement('option');
            option.value = group.name;
            option.id = group.id;
            option.innerHTML = group.name;
            selectGroups.appendChild(option);
        });
    });

//загрузка типов

    function loadTypes() {
        return new Promise (function (resolve, reject) {
            fetch(proxyUrl + 'https://pos.gosuslugi.ru/inbox-service/subsubjects/subject/116/region/22')
                .then(response => response.json())
                .then(types => {
                    resolve(types);
                })
        })
    }

    const selectTypes = document.querySelector('#types');
    loadTypes().then(types => {
        const defaultOption = document.createElement('option');
        defaultOption.innerHTML = 'Выберите тип';
        selectTypes.appendChild(defaultOption);

        types.content.forEach(function (type) {
            const option = document.createElement('option');
            option.value = type.name;
            option.id = type.subject.id;
            option.innerHTML = type.name;
            selectTypes.appendChild(option);
        });
    });

    $('#groups').change(function(){
        const groupId = $(this).find('option:selected').attr('id');
        const typeValues = $("#types>option").map(function() { return $(this).attr('id'); });
        Array.from(typeValues).forEach(function (item) {
            if (item !== groupId) {
                $('#types [id='+`'${item}'`).hide();
            } else {
                $('[id='+`'${item}'`).show();
            }
        })
    });

    $('#leadCreate').on('click',function () {
        const regionName = $('#regions').find('option:selected').val() === 'Выберите регион' ? '' : $('#regions').find('option:selected').val();
        const groupName = $('#groups').find('option:selected').val() === 'Выберите группу' ? '' : $('#groups').find('option:selected').val();
        const typeName = $('#types').find('option:selected').val() === 'Выберите тип' ? '' : $('#types').find('option:selected').val();
        const msg = $('#message-text').val();
        $.ajax({
            url: '/lead/create',
            type: 'POST',
            dataType: 'html',
            data: {
                regionName: regionName,
                groupName: groupName,
                typeName: typeName,
                msg: msg
            },
            success: function (response) {
                $('.modal').modal('hide')
                alert('Заявка успешно создана')
            },
            error: function (response) {
                alert('Ошибка. Данные не отправлены.');
            }
        });
    });
}

$('#btnStatus').on('click',function () {
    const leadId = $(this).data('id');
    const status = $('#statusSelect').find('option:selected').val();
    $.ajax({
        url: '/admin/lead/changeStatus',
        type: 'POST',
        dataType: 'html',
        data: {
            leadId: leadId,
            status: status,
        },
        success: function (response) {
           alert('Статус успешно изменен')
        },
        error: function (response) {
            alert('Ошибка. Данные не отправлены.');
        }
    });
});