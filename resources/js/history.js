document.addEventListener('DOMContentLoaded', function() {
    const selectField = document.querySelector('select[name="field"]');
    const dateFields = document.querySelector('.date-fields');
    const searchForFields = document.querySelector('.search-for');
    const categoryFields = document.querySelector('.category-fields');
    const channelFields = document.querySelector('.channel-fields');

    // Mostrar u ocultar los campos según la opción seleccionada
    selectField.addEventListener('change', function() {
        const selectedOption = this.value;
        if (selectedOption === 'created_at') {
            dateFields.style.display = 'block';
            searchForFields.style.display = 'none';
            categoryFields.style.display = 'none';
            channelFields.style.display = 'none';
        } else if (selectedOption === 'message_category_id') {
            dateFields.style.display = 'none';
            searchForFields.style.display = 'none';
            categoryFields.style.display = 'block';
            channelFields.style.display = 'none';
        } else if (selectedOption === 'notification_channel_id') {
            dateFields.style.display = 'none';
            searchForFields.style.display = 'none';
            categoryFields.style.display = 'none';
            channelFields.style.display = 'block';
        } else if (selectedOption === 'user_name' || selectedOption === 'user_email' || selectedOption === 'user_phone' || selectedOption === 'send_status') {
            dateFields.style.display = 'none';
            searchForFields.style.display = 'block';
            categoryFields.style.display = 'none';
            channelFields.style.display = 'none';
        } else{
            dateFields.style.display = 'none';
            searchForFields.style.display = 'none';
            categoryFields.style.display = 'none';
            channelFields.style.display = 'none';
        }
    });
});
