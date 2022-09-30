
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
        }
    });
});