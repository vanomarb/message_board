<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Board</title>
    <?php echo $this->HTML->css("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"); ?>
    <?php echo $this->HTML->css("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"); ?>
    <?php echo $this->HTML->css("main.css"); ?>
    <?php echo $this->HTML->css("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"); ?>
    <?php echo $this->HTML->script("https://cdn.tailwindcss.com"); ?>
    <?php echo $this->HTML->script("https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"); ?>
    <?php echo $this->HTML->script("readmore.js"); ?>
    <?php echo $this->HTML->script("https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"); ?>
    <?php echo $this->HTML->script("https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"); ?>
    <script>
        var base_url = "<?= $this->webroot; ?>";

        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this,
                    args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };


        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
        var errorMessages = []; // Array to hold error messages
        function validator(self) {
            errorMessages = [];
            $(self).closest('form').find('input').each(function() {
                var input = $(this);
                if (input.attr('notrequired')) {
                    return false;
                };
                var label = $(this).prev().text(); // Get label text
                if (!input.val()) { // Check if the input field is empty
                    errorMessages.push(label + ' is required.');
                }
                if (label == 'Email' && !isEmail(input.val())) {
                    errorMessages.push('Invalid email format.');
                }
            });
        }
    </script>
</head>

<body style="font-family: Poppins;">
    <?php echo $this->Flash->render(); ?>
    <?php if ($currentUser != null && $this->request->params['action'] != 'thankyou') : ?>
        <nav class="z-[1] border-b-[1px] border-slate-500 fixed w-full top-0 left-0 bg-white">
            <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        <!-- Mobile menu button-->
                        <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex flex-shrink-0 items-center">
                            <a href="<?= $this->webroot . 'messages' ?>">
                                <?= $this->HTML->image('unnamed.png', array(
                                    'class' => 'h-8 w-auto',
                                )) ?>
                            </a>
                        </div>
                        <div class="hidden sm:ml-6 sm:block">
                            <div class="flex space-x-4">

                                <a href="<?= $this->webroot . 'messages' ?>" class="rounded-md px-3 py-2 text-sm font-medium <?= $this->request->params['controller'] == 'messages' ? 'bg-gray-900 text-white hover:text-gray-300' : 'text-black hover:bg-gray-700 hover:text-gray-100' ?>" aria-current="page">Home</a>
                                <a href="<?= $this->webroot . 'users/profile' ?>" class="rounded-md px-3 py-2 text-sm font-medium <?= $this->request->params['controller'] == 'users' ? 'bg-gray-900 text-white hover:text-gray-300' : 'text-black hover:bg-gray-700 hover:text-gray-100' ?>" aria-current="page">Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        <!-- Profile dropdown -->
                        <div class="relative ml-3 flex justify-center items-center text-black">
                            <div class="container-user">
                                Hello, User <span class="text-lime-400"><?php echo $currentUser['name']; ?></span>!
                            </div>
                            <div class="container-logout">
                                <a href="<?= $this->webroot . 'users/logout' ?>" class="block px-4 py-2 text-sm text-gray-400 hover:text-black" role="menuitem" tabindex="-1" id="user-menu-item-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="<?= $this->webroot . 'messages' ?>" class="block rounded-md px-3 py-2 text-base font-medium <?= $this->request->params['controller'] == 'users' ? 'bg-gray-900 text-white  hover:text-gray-300' : 'text-black hover:bg-gray-700 hover:text-gray-100' ?>" aria-current="page">Home</a>
                    <a href="<?= $this->webroot . 'users/profile' ?>" class="block rounded-md px-3 py-2 text-base font-medium <?= $this->request->params['controller'] == 'users' ? 'bg-gray-900 text-white  hover:text-gray-300' : 'text-black hover:bg-gray-700 hover:text-gray-100' ?>" aria-current="page">Profile</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>
    <div class="<?= $this->request->params['action'] != 'thankyou' ? 'pt-16' : '' ?>">
        <?php echo $this->fetch('content'); ?>
    </div>
    <script>
        $(document).ready(function() { // Close flash php on click
            $('.fa-close').click(function() {
                $(this).closest('.toast-container').addClass('hidden');
            });
            $('.dropdown-button').click(function(event) {
                event.stopPropagation(); // Prevent this click from triggering the document click event
                //toggle dropdown menu on click
                $('.dropdown-menu').toggleClass('opacity-0 scale-95 opacity-100 scale-100');
            });
            // Close the dropdown when it loses focus
            $('.dropdown-button').blur(function(event) {
                if ($('.dropdown-menu').hasClass('opacity-100')) {
                    $('.dropdown-menu').toggleClass('opacity-100 scale-100 opacity-0 scale-95');
                }
            });
            // Prevent click inside the dropdown from closing the menu
            $('.dropdown-menu').click(function(event) {
                event.stopPropagation();
            });
        });
    </script>
</body>

</html>