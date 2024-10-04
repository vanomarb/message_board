<!-- component -->
<div class="flex h-[91vh] antialiased text-gray-800">
    <div class="flex flex-row h-full w-full overflow-x-hidden">

        <div class="flex flex-col flex-auto h-full p-6 conversation_container" data-cid="<?= $conversation_id ?>">
            <div class="notification-box flex flex-col items-center justify-center rounded-lg text-white border z-50 p-3 bg-red-500 fixed w-[350px] translate-x-[100%] translate-y[5%] hidden"></div>
            <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-50 h-full">
                <div class="grid grid-cols-12 gap-y-2 conversation_details px-4 py-2 border-b-1 bg-gray-200 rounded-t-2xl"></div>
                <div class="flex flex-col h-full overflow-x-auto p-4 conversation_scroller">
                    <div class="flex flex-col h-full">
                        <div class="grid grid-cols-12 gap-y-2 conversation_box"></div>
                    </div>
                </div>
                <?php echo $this->Form->create('Message', [
                    'inputDefaults' => array(
                        'label' => false,
                        'div' => false
                    ),
                    'class' => 'px-4 pb-4'
                ]);
                ?>

                <div class="autoGrowChatBox flex flex-row items-center min-h-16 max-h-36 rounded-xl bg-white w-full px-4">
                    <div>
                        <button
                            class="flex items-center justify-center text-gray-400 hover:text-gray-600">
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-grow ml-4">
                        <div class="relative w-full">
                            <div class="w-full h-full items-start flex-col-reverse flex">
                                <?php
                                echo $this->Form->hidden('sent_to', [
                                    'value' => $conversation_id,
                                ]);
                                ?>
                                <?php
                                echo $this->Form->textarea('content', [
                                    'label' => '',
                                    'id' => 'autoGrowTextarea',
                                    'class' => 'w-full p-2 rounded-md min-h-6 max-h-32 resize-none outline-none',
                                    'placeholder' => 'Type your message...',
                                    'rows' => 1,
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <button class="flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                    <div class="ml-4">
                        <button class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0" type="submit">
                            <span>Send</span>
                            <span class="ml-2">
                                <svg
                                    class="w-4 h-4 transform rotate-45 -mt-px"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let $chatContainer = $('.conversation_scroller');
        let offset = 0; // Initial offset
        let limit = 10; // Number of messages to load per request

        // convert autogrow textarea javascript above to jquery 
        $(document).on('input', '#autoGrowTextarea', function() {
            $(this).css('height', 'auto'); // Reset height to auto to calculate new height
            $(this).css('height', this.scrollHeight + 'px');
            $('.autoGrowChatBox').height(this.scrollHeight + 30);
        })
        $(document).on('click', '.deleteBtn', function(e) {
            e.stopPropagation(); // Stop the click event from propagating to the parent.

            var conversation_id = $(this).data('mid');
            var confirmation = confirm('Are you sure you want to delete this message?');
            var self = $(this); // Store reference to 'this'

            if (confirmation) {
                $.ajax({
                    url: base_url + 'messages/deleteMessage',
                    type: 'POST',
                    data: {
                        conversation_id: conversation_id
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status === "success") {
                            self.closest('.conversation_item').addClass('scale-0');
                            // Listen for the transition end event
                            self.closest('.conversation_item').on('transitionend', function() {
                                self.closest('.conversation_item').remove(); // remove conversation item
                                loadConversations(offset, limit).then(function(data) {
                                    if (data.conversations.data.length == 0) {
                                        window.location.href = base_url + 'messages'
                                    }
                                });
                            });

                        } else {
                            alert(res.message);
                        }
                    }
                });
            }
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
                $.ajax({
                    url: base_url + "messages/new_message",
                    type: "POST",
                    data: $('#MessageIndexForm').serialize(),
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status == "success") {
                            $('.conversation_box').empty(); // reset conversation
                            offset = offset - limit; // this is to enable scrolling again
                            // set offset to 0 to get the latest message
                            loadConversations(0, limit).then(function() {
                                // Scroll to bottom after initial load
                                $chatContainer.scrollTop($chatContainer[0].scrollHeight);
                            })

                            $('#autoGrowTextarea').val(''); // Reset textarea
                            $('#autoGrowTextarea').css('height', '40px'); // Reset textarea height
                        } else {
                            var validationErr = res.message;
                            //create a loop through the validation errors and add them to the errorMessages array in res.message object
                            for (var key in validationErr) {
                                errorMessages.push(validationErr[key]);
                            }
                            $('.notification-box').removeClass('hidden').html(errorMessages.join('<br>'));
                            setTimeout(() => {
                                $('.notification-box').addClass('hidden');
                            }, timeout);
                        }
                    }
                });
            }
        });

        // Load initial messages and scroll to bottom
        loadConversations(offset, limit).then(function(data) {


            // Scroll to bottom after initial load
            $chatContainer.scrollTop($chatContainer[0].scrollHeight);
            offset = data.offset; // Update the offset based on the new offset returned

            // Add scroll event listener
            $chatContainer.on('scroll', function() {
                // Only trigger load more when at the top and the scrollbar exists
                if ($chatContainer.scrollTop() === 0) {
                    loadMoreMessages();
                }

            });
        });

        // Function to load more messages and maintain scroll position
        function loadMoreMessages() {
            const previousScrollHeight = $chatContainer[0].scrollHeight; // Get previous scroll height

            // Load more messages (prepend to the top)
            loadConversations(offset, limit).then(function(data) {
                const newScrollHeight = $chatContainer[0].scrollHeight;
                const heightDifference = newScrollHeight - previousScrollHeight;

                // Scroll to the previous position to maintain scroll
                $chatContainer.scrollTop(heightDifference);
                offset = data.offset; // Update the offset
                $('.convo_item').each(function() {
                    $(this).readmore({
                        speed: 75,
                        moreLink: '<a href="#" class="text-indigo-600">read more</a>',
                        lessLink: '<a href="#" class="text-indigo-600">read less</a>'
                    });
                });
            });
        }

        function handleNoMessages(offset, resolve) {
            const messageContainer = $('.messageListContainer');
            $('.loadingIcon').remove();
            if ($('.conversation_box').find('.emptyMessage').length === 0) {
                $('.conversation_box').prepend(`
                    <div class="emptyMessage conversation_item col-start-1 col-end-13 m-3 rounded-lg text-center">
                        No more messages to load.
                    </div>
                `);

            }
        }
        // Function to load conversations via AJAX
        function loadConversations(offset, limit) {
            const conversation_id = $('.conversation_container').data('cid');

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${base_url}messages/loadConversations`,
                    type: 'GET',
                    data: {
                        conversation_id,
                        offset,
                        limit
                    },
                    beforeSend: function() { // Load loading icon before appending message
                        $('.conversation_box').prepend(`
                         <div class="loadingIcon conversation_item col-start-1 col-end-13 m-3 rounded-lg text-center flex items-center justify-center">
                            <div class="rounded-full bg-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="50" height="50" class="p-2" style="shape-rendering: auto; display: block; background: transparent;"><g><circle stroke-linecap="round" fill="none" stroke-dasharray="50.26548245743669 50.26548245743669" stroke="#69fff8" stroke-width="8" r="32" cy="50" cx="50">
                                <animateTransform values="0 50 50;360 50 50" keyTimes="0;1" dur="1s" repeatCount="indefinite" type="rotate" attributeName="transform"/>
                                </circle><g/></g>
                                </svg>
                            </div>
                        </div>
                    `);
                    },
                    success: function(response) {

                        const conversations = JSON.parse(response);
                        if (conversations.data.length === 0) {
                            handleNoMessages();
                            return;
                        }
                        if (conversations.data.length > 0) {
                            const chatHTML = buildChatHTML(conversations.data);
                            $('.loadingIcon').remove();

                            $('.conversation_box').prepend(chatHTML); // Prepend new messages to maintain order

                            offset += limit; // Update offset based on the limit
                        }
                        resolve({
                            offset,
                            conversations
                        });
                    },
                    error: function(err) {
                        console.error("AJAX error:", err);
                        reject(err);
                    }
                });
            });
        }

        function buildChatHTML(messages) {
            let chatHTML = ''; // Initialize chatHTML outside the loop

            // Iterate through messages in reverse order to keep the latest at the bottom
            messages.forEach(message => {
                const isSender = message.sender_id == message.auth_user;

                // Determine the receiver based on whether the auth_user is the sender or receiver
                const receiverId = isSender ? message.receiver_id : message.sender_id;
                const receiverName = isSender ? message.receiver_name : message.sender_name;
                const receiverImage = isSender ? message.receiver_image : message.sender_image;

                // Build avatars for both sender and receiver
                const senderHTML = buildUserAvatar(message.sender_id, message.sender_name, message.sender_image);
                const receiverHTML = buildUserAvatar(receiverId, receiverName, receiverImage);

                // Build the message template based on whether the auth_user is the sender
                const template = `
            <div class="conversation_item ${isSender ? 'col-start-6 col-end-13' : 'col-start-1 col-end-8'} m-3 rounded-lg transition-all duration-150 ease-out scale-100">
                <div class="group flex ${isSender ? 'flex-row-reverse justify-start' : 'flex-row'}">
                    <a href="${base_url + 'users/profile?uid=' + message.sender_id}">
                        ${senderHTML}
                    </a>
                    <div class="relative text-sm ${isSender ? 'bg-indigo-100 mr-3' : 'bg-white ml-3'} py-2 px-4 shadow rounded-xl max-w-[80%]">
                        <div class="convo_item max-h-[140px] overflow-y-hidden">${message.content}</div>
                    </div>
                    ${isSender ? buildDeleteButton(message.message_id) : ''}
                </div>
            </div>`;

                // Set receiver details based on the user being the sender or receiver
                const templateDetails = buildReceiverDetails({
                    receiver_id: receiverId,
                    receiver_name: receiverName,
                    receiver_image: receiverImage
                });
                $('.conversation_details').html(templateDetails);

                // Prepend to maintain the correct order
                chatHTML = template + chatHTML;
            });

            return chatHTML; // Return the final HTML string
        }

        // Build the user avatar (this function stays the same)
        function buildUserAvatar(userId, userName, userImage) {
            return userImage ?
                `<img src="${base_url + 'img/uploads/' + userImage}" class="rounded-full h-10 w-10">` :
                `<div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 text-white capitalize">${userName[0]}</div>`;
        }

        // Build receiver details HTML (this function stays the same)
        function buildReceiverDetails(receiver) {
            const receiverHTML = buildUserAvatar(receiver.receiver_id, receiver.receiver_name, receiver.receiver_image);
            return `
                <div class="col-start-1 col-end-8 py-3 pr-3 rounded-lg">
                    <div class="flex flex-row items-center">
                        <a href="${base_url + 'messages'}" class="relative mr-3 text-lg hover:bg-slate-500 rounded-full flex items-center cursor-pointer">
                            <svg width="10" height="40" viewBox="0 -9 3 24" class="text-slate-400 hover:text-slate-100 -rotate-180 w-10">
                                <path d="M0 0L3 3L0 6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                        </a>
                        <a class="flex flex-row items-center" href="${base_url + 'users/profile?uid=' + receiver.receiver_id}">
                            ${receiverHTML}
                            <div class="relative mr-3 text-lg py-2 px-4">
                                <div>${receiver.receiver_name}</div>
                            </div>
                        </a>
                    </div>
                </div>`;
        }



        // Build user avatar HTML
        function buildUserAvatar(userId, userName, userImage) {
            return userImage ?
                `<img src="${base_url + 'img/uploads/' + userImage}" class="rounded-full h-10 w-10">` :
                `<div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 text-white capitalize">${userName[0]}</div>`;
        }

        // Build receiver details HTML
        function buildReceiverDetails(receiver) {
            // const isSender = message.sender_id == message.auth_user;
            // var receiver_id = conversations.data[i].receiver_id;
            // var receiver_name = conversations.data[i].receiver_name;
            // var receiver_image = conversations.data[i].receiver_image;
            const receiverHTML = buildUserAvatar(receiver.receiver_id, receiver.receiver_name, receiver.receiver_image);
            return `
        <div class="col-start-1 col-end-8 py-3 pr-3 rounded-lg">
            <div class="flex flex-row items-center">
                <a href="${base_url + 'messages'}" class="relative mr-3 text-lg hover:bg-slate-500 rounded-full flex items-center cursor-pointer">
                    <svg width="10" height="40" viewBox="0 -9 3 24" class="text-slate-400 hover:text-slate-100 -rotate-180 w-10">
                        <path d="M0 0L3 3L0 6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </a>
                <a class="flex flex-row items-center" href="${base_url + 'users/profile?uid=' + receiver.receiver_id}">
                    ${receiverHTML}
                    <div class="relative mr-3 text-lg py-2 px-4">
                        <div>${receiver.receiver_name}</div>
                    </div>
                </a>
            </div>
        </div>`;
        }

        // Build delete button HTML
        function buildDeleteButton(messageId) {
            return `
        <div class="relative top-[-15px] deleteContainer">
            <button class="deleteBtn ellipsis-btn flex items-center justify-center bg-gray-200 rounded-full w-8 h-8 absolute top-[50%] transform opacity-0 translate-x-10 group-hover:opacity-100 group-hover:translate-x-0 mr-2 right-0" data-mid="${messageId}">
                <svg class="w-4 h-4 fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                </svg>
            </button>
        </div>`;
        }

        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }



    })
</script>