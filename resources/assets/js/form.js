$(document).ready(() => {
    // Loop for each .beluga-addable
    $('.beluga-addable').each((index, element) => {
        // Retrieve the route
        let route = $(element).data('route');
        
        // Ajax call to get the form
        $.ajax({
            url: route,
            type: 'GET',
            success: (data) => {
                // Append the form to the .beluga-addable
                $(element).append(data);

                // Preprend the error container
                $(element).prepend('<div class="beluga-addable-error"></div>');

                let form = $(element).find('form'),
                    submit = $(element).find('button[type="submit"]');

                let action = form.attr('action'),
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

                    console.log(action, method, sendingDatas)

                    // Ajax call to submit the form
                    $.ajax({
                        url: action,
                        type: method,
                        data: sendingDatas,
                        success: (data) => {
                            // Append the data to the .beluga-addable
                            $(element).append(data);
                        },
                        error: (data) => {
                        // Get the error container
                            let error = $(element).find('.beluga-addable-error');

                            // Append the error
                            error.html('<div class="alert alert-danger">'+data.responseJSON.message+'</div>');
                        }
                    });
                });
            }
        });
    });
});