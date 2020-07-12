var formBuilderIns;
function formBuilder(id, formDataEntity, urlShowForm, orderAvailableFields, disabledFields) {
    var disabledAttrs = ['access', 'description', 'toggle', 'inline', 'other', 'step'];

    var actionButtons = [];
    if (id && urlShowForm) {
        // actionButtons = [{
        //     id: 'show',
        //     className: 'btn btn-light',
        //     label: '<i class="fas fa-eye"></i>',
        //     type: 'button',
        //     events: {
        //         click: function () {
        //             window.location.href = urlShowForm;
        //         }
        //     }
        // }]
    }

    var fbOptions = {
        onSave: function(e, formData) {
            console.log(e, formData)
            window.sessionStorage.setItem('formData', JSON.stringify(formData));
            //saveBuilderForm(formData, id);
        },
        onClearAll: function(e) {
            deleteBuilderForm(id);
        },
        stickyControls: {
            enable: true
        },
        actionButtons: actionButtons,
        //disableFields: disabledFields,
        disabledFieldButtons: {
            text: ['copy']
        },
        disabledActionButtons: ['data', 'save', 'clear'],
        controlOrder: orderAvailableFields,
        fieldRemoveWarn: true,
      
        disabledAttrs
    };
    // var formData = window.sessionStorage.getItem('formData');

    // if (formData) {
    //     fbOptions.formData = formData;
    // }
    if (formDataEntity) {
        console.log(formDataEntity);
        fbOptions.formData = formDataEntity;
    }
    console.log(fbOptions)

    
    setTimeout(() => {
      formBuilderIns = $('.build-wrap').formBuilder(fbOptions);
    }, 1000);
    

    bootstrap_alert = function() {};
    bootstrap_alert.success = function(message) {
        $('#alert_placeholder').html('<div class="alert alert-success alert-dismissable fade show"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
    };
    bootstrap_alert.warning = function(message) {
        $('#alert_placeholder').html('<div class="alert alert-danger alert-dismissable fade show"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
    };
}


$('#saveFormBuilderBtn').click(function() {
    console.log()
    var formData = JSON.stringify(formBuilderIns.actions.getData());
    window.sessionStorage.setItem('formData', JSON.stringify(formData));
    saveBuilderForm(formData, id);

})

// $('#saveFormBuilderBtn').click(function() {
//     console.log()
//     var formData = JSON.stringify(formBuilderIns.actions.getData());
//     window.sessionStorage.setItem('formData', JSON.stringify(formData));
//     saveBuilderForm(formData, id);

// })

function saveBuilderForm(formBuilderData, id) {

    var inputFile = $('[name="formBuilderImage"]')[0];

    var file = inputFile.files[0];
        
    var formData = new FormData();
    formData.append('formBuilderImage', file);
    formData.append('formData', formBuilderData);
    formData.append('formName', $('#formNameEdit input').val());
    formData.append('id', id);
    
    $.ajax({
        type: 'POST',
        url: urlSaveForm,
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        // data: {
        //     formData: formBuilderData,
        //     formName: $('#formNameEdit input').val(),
        //     id: id
        // },
        success: function(data) {
           
            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else if (!data.success && data.msg) {
                bootstrap_alert.warning(data.msg);
            } else {
                bootstrap_alert.warning('');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            bootstrap_alert.warning('Something went wrong');
        }
    });
}

function deleteBuilderForm(id) {
    if (!id) {
        return false;
    }

    $.ajax({
        type: 'POST',
        url: urlDeleteForm,
        data: {
            id: id
        },
        success: function(data) {
            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else {
                bootstrap_alert.warning('Something went wrong');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            bootstrap_alert.warning('Something went wrong');
        }
    });
}

$(window).scroll(function() {
    if ($(document).scrollTop() > 50) {
        $('nav').addClass('shrink');
    } else {
        $('nav').removeClass('shrink');
    }
});

$(document).ready(function () {
    $('#formName .name').html($('#formNameEdit input').val());

    $('#formName .fa-edit').on('click', function () {
        $('#formName').addClass('d-none');
        $('#formNameEdit').removeClass('d-none');
    });

    $('#formNameEdit .fa-check').on('click', function () {
        $('#formName').removeClass('d-none');
        $('#formNameEdit').addClass('d-none');
        $('#formName .name').html($('#formNameEdit input').val());
    });
});
