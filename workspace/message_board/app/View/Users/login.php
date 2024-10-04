<div class="users form max-w-lg m-auto p-20">
    <div class="<?php echo ($this->Session->check('Message.auth')) ? '' : 'hidden'; ?> fixed right-5 top-3 w-64 flex justify-between p-4 rounded-md shadow-slate-400 shadow-lg border-white bg-red-500 toast-container">
        <div class="flex items-center justify-between">
            <div class="icon-container w-16">
                <i class="fa fa-exclamation-circle text-white text-4xl"></i>
            </div>
            <div class="message-container w-full text-sm text-white leading-5">
                <?php echo $this->Flash->render('auth'); ?>
            </div>
        </div>
        <div class="flex">
            <div class="icon-container leading-5 relative -pl-2">
                <i class="fas fa-close text-white text-sm px-[5px] hover:bg-white hover:text-black rounded-full cursor-pointer"></i>
            </div>
        </div>
    </div>

    <h1 class="text-2xl font-bold mb-16 text-center">Login</h1>
    <?php
    echo $this->Form->create('User', ['class' => 'space-y-4']);
    ?>
    <div class="notification-box flex flex-col items-center justify-center rounded-lg text-white border w-full z-50 p-3 bg-red-500 hidden">

    </div>
    <?php
    echo $this->Form->input('email', [
        'label' => 'Email',
        'class' => 'border rounded-md p-2 w-full',
        'placeholder' => 'Enter your email'
    ]);
    ?>

    <?php
    echo $this->Form->input('password', [
        'label' => 'Password',
        'type' => 'password',
        'class' => 'border rounded-md p-2 w-full',
        'placeholder' => 'Enter your password'
    ]);
    ?>

    <?php

    $options = array(
        'label' => 'Login',
        'class' => 'bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 w-full mt-1',
    );
    echo $this->Form->end($options);
    ?>
    <a href="register" class="text-sm text-blue-500 hover:underline">Create account.</a>
</div>

<script>
    $(document).ready(function() {
        $("input[value='Login").click(function(e) {
            e.preventDefault();
            validator($(this));
            if (errorMessages.length > 0) {
                $('.notification-box').removeClass('hidden').html(errorMessages.join('<br>')); // Show error messages
            } else {
                $.ajax({
                    url: "/message_board/users/login",
                    type: "POST",
                    data: $('#UserLoginForm').serialize(),
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
            return false;
        });
    });
</script>