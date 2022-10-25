// Update table
function updateTable(element, route) {
    // Set loading state on element
    element.html(`<div class="spinner-grow text-blue" role="status"></div>
    <div class="spinner-grow text-azure" role="status"></div>
    <div class="spinner-grow text-indigo" role="status"></div>
    <div class="spinner-grow text-purple" role="status"></div>
    <div class="spinner-grow text-pink" role="status"></div>
    <div class="spinner-grow text-red" role="status"></div>
    <div class="spinner-grow text-orange" role="status"></div>
    <div class="spinner-grow text-yellow" role="status"></div>
    <div class="spinner-grow text-lime" role="status"></div>
    <div class="spinner-grow text-green" role="status"></div>
    <div class="spinner-grow text-teal" role="status"></div>
    <div class="spinner-grow text-cyan" role="status"></div>`);
    $.ajax({
        url: route,
        type: 'GET',
        success: (data) => {
            element.html(data);
        },
        error: (data) => {
            console.log(data);
        }
    })
}


$(document).ready(() => {
    // Loop for each .beluga-addable
    $('.beluga-addable').each((index, element) => {
        // Retrieve the route
        let route = $(element).data('route');

        updateTable(
            $(element).find(".beluga-addable-list"),
            $(element).data('table-route')
        );
        // Ajax call to get the form
        $.ajax({
            url: route,
            type: 'GET',
            success: (data) => {
                // Append the form to the .beluga-addable
                $(element).append(data);

                // Preprend the error container
                $(element).prepend('<div class="beluga-addable-error"></div>');

                // Get parent name
                let parentName = $(element).data('parent'),
                    settings = $(element).data('settings');

                // Set parent id input value
                let parentId = $("#beluga-form-" + parentName).find('input[name="id"]').val()

                let parentIdInput = 'input[name="' + (settings.foreign_key ? settings.foreign_key : parentName + '_id') + '"]'
                $(element).find(parentIdInput).val(parentId);
                $(element).find(parentIdInput).hide();

                if (settings.where) {
                    $(element).find('input[name="' + settings.where[0] + '"]').val(settings.where[1]);
                    $(element).find('input[name="' + settings.where[0] + '"]').hide();
                }

                let form = $(element).find('form'),
                    submit = $(element).find('button[type="submit"]');

                // Get action route without id
                let actionRoute = form.attr('action').split('/'),
                    action = actionRoute.slice(0, actionRoute.length - 1).join('/'),
                    method = form.attr('method');

                // On submit
                submit.click((event) => {
                    // Prevent default
                    event.preventDefault();

                    // Get the data
                    let data = form.serializeArray();

                    let sendingDatas = {};
                    data.forEach((element) => {
                        sendingDatas[element.name] = element.value;
                    });
                    // Add checkbox inputs
                    form.find('input[type="checkbox"]').each((index, element) => {
                        sendingDatas[$(element).attr('name')] = $(element).is(':checked') ? 1 : 0;
                    });

                    // Ajax call to submit the form
                    $.ajax({
                        url: action,
                        type: method,
                        data: sendingDatas,
                        success: (data) => {
                            updateTable(
                                $(element).find(".beluga-addable-list"),
                                $(element).data('table-route')
                            );
                        },
                        error: (data) => {
                            let error = $(element).find('.beluga-addable-error');
                            error.html('<div class="alert alert-danger">'+data.responseJSON.message+'</div>');
                        }
                    });
                });
            }
        });
    });
});