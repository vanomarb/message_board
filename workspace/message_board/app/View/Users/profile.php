<style>
    /* modernize jQuery UI datepicker to match the theme design of tailwind */
    .ui-datepicker {
        padding: .7em .7em;
        font-family: 'Poppins';
    }

    /* current input value background color */
    .ui-datepicker-current-day a {
        background: #eef2ff!important;
        border-radius:  8px;
    }



    .ui-widget-content {
        margin-top: 5px;
        border: none !important;
        box-shadow: 0px 14px 15px 9px rgba(0, 0, 0, .1), 0 4px 6px -4px rgba(0, 0, 0, .1);
    }

    .ui-widget-header {
        font-weight: normal;
    }

    .ui-datepicker .ui-datepicker-title {
        margin: 0 2em;
    }

    .ui-datepicker select.ui-datepicker-month {
        margin-right: 5px;
    }

    .ui-datepicker select.ui-datepicker-year {
        margin-left: 5px;
    }

    .ui-datepicker th {
        font-weight: normal;
        color: #9b9b9b;
    }

    .ui-datepicker .ui-datepicker-header {
        padding: 0.5em 0;
        background: transparent;
        border: none;

    }

    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next {
        top: 0.5em;
    }


    .ui-state-default,
    .ui-widget-content .ui-state-default {
        font-weight: normal;
        color: #454545;
        text-align: center;
        padding: 5px 5px;
        border: none;
        background: transparent;
    }

    .ui-state-highlight,
    .ui-widget-content .ui-state-highlight,
    .ui-widget-header .ui-state-highlight {
        border-radius: 8px;
        background-color: rgb(26 86 219 / 1);
        color: white;
    }

    .ui-datepicker .ui-datepicker-prev-hover {
        left: 2px;
        cursor: pointer;
    }

    .ui-datepicker .ui-datepicker-next-hover {
        right: 2px;
        cursor: pointer;
    }

    .ui-state-hover,
    .ui-widget-content .ui-state-hover,
    .ui-widget-header .ui-state-hover,
    .ui-state-focus,
    .ui-widget-content .ui-state-focus,
    .ui-widget-header .ui-state-focus,
    .ui-button:hover,
    .ui-button:focus {
        border: none;
        font-weight: normal;
        color: #454545;
        text-align: center;
        padding: 5px 5px;
        background: #ededed;
        border-radius: 8px;
    }
</style>
<div class="container mx-auto bg-white w-full flex flex-col items-center px-3 md:px-16 lg:px-28 text-[#161931]">
    <main class="w-full py-1 md:w-2/3 lg:w-3/4">
        <div class="px-2 md:px-4">
            <div class="w-full px-6 pb-8 mt-8 sm:max-w-xl sm:rounded-lg">
                <h2 class="pl-6 text-2xl font-bold sm:text-xl text-center">Profile</h2>
                <?php echo $this->Form->create('User', ['class' => 'space-y-4']);  ?>
                <div class="notification-box flex flex-col items-center justify-center rounded-lg text-white border w-full z-50 p-3 bg-red-500 hidden"></div>
                <div class="grid max-w-2xl mx-auto mt-8 profileContainer group">
                    <div class="flex flex-col items-center space-y-5 sm:flex-row sm:space-y-0">
                        <div class="relative w-40 h-40 rounded-full ring-2 ring-indigo-300 dark:ring-indigo-500 bg-indigo-500 flex items-center justify-center overflow-hidden">
                            <?php if ($userProfile['image']) : ?>
                                <img class="previewImage object-cover w-full h-full scale-105 rounded-full"
                                    src="<?= $this->webroot . 'img/uploads/' . $userProfile['image'] ?>"
                                    alt="Bordered avatar">

                            <?php else: ?>
                                <img class="previewImage object-cover w-full h-full rounded-full opacity-0"
                                    alt="No image available">
                                <span class="absolute text-white text-5xl capitalize"><?= $userProfile['name'][0] ?></span>
                            <?php endif; ?>
                        </div>



                        <div class="flex flex-col space-y-5 sm:ml-8">
                            <?php if ($userProfile['id'] == $currentUser['id']) : ?>
                                <button type="button"
                                    class="to_update updateProfileBtn py-3.5 px-7 mt-10 text-base font-medium text-indigo-100 focus:outline-none bg-[#202142] rounded-lg border border-indigo-200 hover:bg-indigo-900 focus:z-10 focus:ring-4 focus:ring-indigo-200 ">
                                    Update Profile
                                </button>
                            <?php
                                echo $this->Form->input('image', [
                                    'type' => 'file',
                                    'class' => 'hidden',
                                    'id' => 'uploadImage',
                                    'notrequired' => true,
                                    'label' => [
                                        'class' => 'uploadImageBtn to_view hidden group-[.update]:flex py-3.5 px-7 text-base font-medium text-gray-600 focus:outline-none bg-transparent rounded-lg border border-indigo-200 hover:bg-gray-200 focus:z-10 focus:ring-4 focus:ring-indigo-200 cursor-pointer',
                                        'text' => 'Upload image'
                                    ]
                                ]);
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="items-center mt-8 sm:mt-14 text-[#202142]">
                        <div
                            class="flex flex-col items-center w-full mb-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                            <div class="w-full">
                                <label for="first_name"
                                    class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white"> Name</label>
                                <?php
                                echo $this->Form->input('name', [
                                    'label' => '',
                                    'class' => 'to_view disabled:opacity-100 bg-white group-[.update]:bg-indigo-50 border border-white group-[.update]:border-indigo-300 group-[.update]:text-indigo-900 text-sm group-[.update]:rounded-lg group-[.update]:focus:ring-indigo-500 group-[.update]:focus:border-indigo-500 block w-full p-2.5',
                                    'placeholder' => 'Enter your name',
                                    'disabled' => true,
                                    'value' => $userProfile['name'],

                                ]);
                                ?>
                            </div>

                            <div class="w-full">
                                <label for="last_name"
                                    class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white"> Birthdate</label>

                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <?php
                                    echo $this->Form->input('birthdate', [
                                        'id' => 'default-datepicker',
                                        'type' => 'text',
                                        'label' => '',
                                        'notrequired' => true,
                                        'class' => 'to_view disabled:opacity-100 bg-white group-[.update]:bg-indigo-50 border border-white group-[.update]:border-indigo-300 text-indigo-900 text-sm rounded-lg group-[.update]:focus:ring-indigo-500 group-[.update]:focus:border-indigo-500 block w-full ps-10 p-2.5',
                                        'placeholder' => 'Birthdate',
                                        'disabled' => true,
                                        'data-date' => $userProfile['birthdate'] ? $userProfile['birthdate'] : '',
                                        'value' => $userProfile['birthdate'] ? date('F d, Y', strtotime($userProfile['birthdate'])) : '',
                                    ]);
                                    ?>
                                </div>

                            </div>

                        </div>

                        <div class="flex flex-col items-center w-full mb-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                            <div class="w-full">

                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Email</label>
                                <?php
                                echo $this->Form->input('email', [
                                    'label' => '',
                                    'class' => 'to_view disabled:opacity-100 bg-white group-[.update]:bg-indigo-50 border border-white group-[.update]:border-indigo-300 group-[.update]:text-indigo-900 text-sm group-[.update]:rounded-lg group-[.update]:focus:ring-indigo-500 group-[.update]:focus:border-indigo-500 block w-full p-2.5',
                                    'placeholder' => 'Enter your email',
                                    'disabled' => true,
                                    'value' => $userProfile['email'],
                                ]);
                                ?>
                            </div>
                            <div class="w-full">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Joined</label>
                                <div class="to_view disabled:opacity-100 bg-white group-[.update]:bg-indigo-50 border border-white group-[.update]:border-indigo-300 group-[.update]:text-indigo-900 text-sm group-[.update]:rounded-lg group-[.update]:focus:ring-indigo-500 group-[.update]:focus:border-indigo-500 block w-full p-2.5">
                                    <?= date('F d, Y h:i a', strtotime($userProfile['date_added'])) ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center w-full mb-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                            <div class="w-full">
                                <label for="profession"
                                    class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Gender
                                </label>
                                <div class="flex items-center mb-4 flex-row">
                                    <?php
                                    echo $this->Form->input('gender', [
                                        'div' => [
                                            'class' => 'flex items-center justify-center'
                                        ],
                                        'type' => 'radio',
                                        'options' => [
                                            '1' => 'Male',
                                        ],
                                        'notrequired' => true,
                                        'class' => 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer disabled:opacity-100',
                                        'disabled' => true,
                                        'label' => [
                                            'class' => 'ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer'
                                        ],
                                        'hiddenField' => false,
                                        'fieldset' => false,
                                        'legend' => false,
                                        'checked' => $userProfile['gender'] == 1 ? 'checked' : '',
                                    ]);
                                    ?>
                                </div>
                                <div class="flex items-center">
                                    <?php
                                    echo $this->Form->input('gender', [
                                        'div' => [
                                            'class' => 'flex items-center justify-center'
                                        ],
                                        'type' => 'radio',
                                        'options' => [
                                            '2' => 'Female',
                                        ],
                                        'notrequired' => true,
                                        'checked' => 'checked',
                                        'class' => 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer disabled:opacity-100 block',
                                        'disabled' => true,
                                        'label' => [
                                            'class' => 'ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer'
                                        ],
                                        'hiddenField' => false,
                                        'fieldset' => false,
                                        'legend' => false,
                                        'checked' => $userProfile['gender']  == 2 ? 'checked' : '',
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Last login</label>
                                <div class="to_view disabled:opacity-100 bg-white group-[.update]:bg-indigo-50 border border-white group-[.update]:border-indigo-300 group-[.update]:text-indigo-900 text-sm group-[.update]:rounded-lg group-[.update]:focus:ring-indigo-500 group-[.update]:focus:border-indigo-500 block w-full p-2.5">
                                    <?= date('F d, Y h:i a', strtotime($userProfile['last_login_time'])) ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="message"
                                class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Bio</label>
                            <?php

                            echo $this->Form->textarea('hobby', [
                                'label' => '',
                                'notrequired' => true,
                                'class' => 'to_view disabled:opacity-100 bg-white block p-2.5 w-full text-sm group-[.update]:text-indigo-900 group-[.update]:bg-indigo-50 rounded-lg border border-white group-[.update]:border-indigo-300 group-[.update]:focus:ring-indigo-500 group-[.update]:focus:border-indigo-500',
                                'placeholder' => 'Write your bio here...',
                                'rows' => 4,
                                'disabled' => true,
                                'value' => $userProfile['hobby'],
                            ]);
                            ?>

                        </div>
                        <?php if ($userProfile['id'] == $currentUser['id']) : ?>
                            <div class="flex justify-end">
                                <div class="flex justify-between">
                                    <button type="button"
                                        class="to_view hidden group-[.update]:flex cancelProfileBtn text-white bg-red-700  hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 mr-4">Cancel</button>
                                    <button type="submit"
                                        class="to_view hidden group-[.update]:flex text-white bg-indigo-700  hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">Save</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>

            </div>
        </div>
    </main>
</div>
<script>
    // Create a jQuery plugin that wraps around the Flowbite Datepicker
    $('#uploadImage').on('change', function() {
        const file = this.files[0]; // Accessing the file using 'this' in the context of the event handler
        if (file) {
            const imgSrc = URL.createObjectURL(file); // Create the object URL
            $('.previewImage').attr('src', imgSrc); // Set the source of the image using jQuery
            $('.previewImage').removeClass('opacity-0');
            $('.previewImage').next().addClass('hidden');
        }
    });

    $(document).ready(function() {
        $('#default-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autohide: true,
            autoSelectToday: true,
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            beforeShow: function(input, inst) {
                console.log($(this).attr('data-date'))
                $(this).datepicker("setDate", $(this).attr('data-date'));
            },
        });

        $('.updateProfileBtn').click(function() {
            $(this).closest('.profileContainer').addClass('update');
            $(this).closest('.profileContainer').find('input, textarea').each(function() {
                $(this).prop('disabled', false);
            })
            $(this).addClass('hidden');

        })
        $('.cancelProfileBtn').click(function() {
            $(this).closest('.profileContainer').removeClass('update');
            $(this).closest('.profileContainer').find('input, textarea').each(function() {
                $(this).prop('disabled', true);
            })
            $('.updateProfileBtn').removeClass('hidden');

        });
        $("button[type='submit").click(function(e) {
            e.preventDefault();
            validator($(this));
            if (errorMessages.length > 0) {
                $('.notification-box').removeClass('hidden').html(errorMessages.join('<br>')); // Show error messages
            } else {
                var conversation_id = $('.conversation_container').data('cid');
                var content = $('#autoGrowTextarea').val();
                if (content == '') {
                    return false;
                }
                // Get the form element
                var formElement = $('#UserProfileForm')[0];
                var formData = new FormData(formElement); // Create a FormData object

                $.ajax({
                    url: base_url + "users/profile",
                    type: "POST",
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Set the content type to false so jQuery will send the request as multipart/form-data
                    success: function(response) {
                        var res = JSON.parse(response);
                        var errorMessages = []; // Reset errorMessages

                        if (res.status === "success") {
                            location.reload();
                        } else {
                            var validationErr = res.message;
                            //create a loop through the validation errors and add them to the errorMessages array in res.message object
                            for (var key in validationErr) {
                                errorMessages.push(validationErr[key]);
                            }
                            $('.notification-box').removeClass('hidden').html(errorMessages.join('<br>'));
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors (like network issues)
                        $('.notification-box').removeClass('hidden').html('An error occurred. Please try again later.');
                    }
                });

            }
        });
    });
</script>