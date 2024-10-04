<div class="users form max-w-xl m-auto p-20">
    <div class="notification-box flex flex-col items-center justify-center rounded-lg text-white border w-full z-50 p-3 bg-red-500 hidden"></div>

    <?php
    echo $this->Form->create('Message', ['class' => 'space-y-4']);
    echo $this->Form->input('sent_to', [
        'type' => 'select',
        'label' => 'Recipient',
        'class' => 'border rounded-md p-2 w-full select2-recipient',
        'empty' => 'Select recipient...',
    ]);

    echo $this->Form->textarea('content', [
        'label' => 'Email',
        'class' => 'border rounded-md p-2 w-full',
        'placeholder' => 'Enter your email',
        'rows' => 10,
    ]);

    $options = array(
        'label' => 'Send',
        'class' => 'bg-blue-500 border-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 w-full mt-1',
    );
    echo $this->Form->end($options);
    ?>
</div>
<script>
    $(document).ready(function() {
        $(document).ready(function() {
            // Initialize the Select2 dropdown
            $("input[value='Send").click(function(e) {
                e.preventDefault();
                validator($(this));
                if (errorMessages.length > 0) {
                    $('.notification-box').removeClass('hidden').html(errorMessages.join('<br>')); // Show error messages
                } else {
                    $.ajax({
                        url: base_url + "messages/new_message",
                        type: "POST",
                        data: $('#MessageNewMessageForm').serialize(),
                        success: function(response) {
                            var res = JSON.parse(response);
                            if (res.status == "success") {
                                window.location.href = "/message_board/messages";
                            } else {
                                var validationErr = res.message;
                                //create a loop through the validation errors and add them to the errorMessages array in res.message object
                                for (var key in validationErr) {
                                    errorMessages.push(validationErr[key]);
                                }
                                $('.notification-box').removeClass('hidden').html(errorMessages.join('<br>'));
                            }
                        }
                    });
                }
            });
            $('.select2-recipient').select2({
                ajax: {
                    url: base_url + 'messages/getUsers',
                    dataType: 'json',
                    delay: 250, // optional: delay in milliseconds before triggering the AJAX request
                    data: function(params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        // map data to Select2 format
                        var parse = data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                                image: item.image
                            };
                        });
                        return {
                            results: parse
                        };
                    },
                    cache: true // optional: cache the results
                },
                templateResult: formatUser, // Customized dropdown list
                templateSelection: formatUserSelection // Customized dropdown list item
            }).on('select2:select', function(e) {});


            // Function to format each user in the dropdown list
            function formatUser(user) {
                var img = `<div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-500 text-white capitalize mr-3">${user.text[0]}</div>`;
                if (user.image) {
                    img = `<img src="${base_url + 'img/uploads/' + user.image}" class="p-1 mr-3 w-12" />`
                }
                var $state = $(
                    '<div class="flex items-center"> ' + img + ' <span>' + user.text + '</span></div>'
                );

                return $state;
            }

            function formatUserSelection(user) {
                var img = `<div class="flex items-center justify-center h-6 w-6 rounded-full bg-indigo-500 text-white capitalize mr-3 text-xs">${user.text[0]}</div>`;
                if (user.image) {
                    img = `<img src="${base_url + 'img/uploads/' + user.image}" class="p-1 mr-3 w-6" />`
                }

                if (!user.id) {
                    return user.text;
                }

                var $state = $(
                    '<div class="flex items-center"> ' + img + '<span>' + user.text + '</span></div>'
                );
                return $state;

            }
        });

    });
</script>