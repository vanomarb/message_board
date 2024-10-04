<!-- component -->
<div class="flex h-[91vh] antialiased text-gray-800">
    <div class="flex flex-row h-full w-full overflow-x-hidden">

        <div class="flex flex-col flex-auto h-full p-6 conversation_container" data-cid="<?= $conversation_id ?>">
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
            e.stopPropagation(); // Stop the click event from propagating to the parent .messageItem

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
                            loadConversations(offset, limit).then(function(data) {
                                console.log(data.conversations.data.length);
                                if (data.conversations.data.length == 0) {
                                    window.location.href = base_url + 'messages'
                                }
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
                            loadConversations(offset, limit);
                            $('#autoGrowTextarea').val(''); // Reset textarea
                            $('#autoGrowTextarea').css('height', '40px'); // Reset textarea height
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

        // Load initial messages and scroll to bottom
        loadConversations(offset, limit).then(function(data) {
            // Scroll to bottom after initial load
            $chatContainer.scrollTop($chatContainer[0].scrollHeight);
            var newOffset = data.offset
            // Update the offset based on the new offset returned by loadConversations
            offset = newOffset;

            // Mark the initial load as complete

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
            // Get the current first element to maintain scroll position
            let firstEl = $chatContainer.find('.conversation_item').first();
            let previousScrollHeight = $chatContainer[0].scrollHeight;

            // Load more messages (prepend to the top)
            loadConversations(offset, limit).then(function(data) {
                var newOffset = data.offset
                // After prepending, calculate the new scroll position to maintain it
                let newScrollHeight = $chatContainer[0].scrollHeight;
                let heightDifference = newScrollHeight - previousScrollHeight;

                // Scroll to the previous first element (maintain position)
                $chatContainer.scrollTop(heightDifference);

                // Update the offset based on the new offset returned
                offset = newOffset;
            });
        }

        // Function to load conversations via AJAX
        function loadConversations(offset, limit) {
            let conversation_id = $('.conversation_container').data('cid');
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: base_url + 'messages/loadConversations',
                    type: 'GET',
                    data: {
                        conversation_id: conversation_id,
                        offset: offset,
                        limit: limit
                    },
                    success: function(response) {
                        var conversations = JSON.parse(response);
                        var chatHTML = '';
                        let lastSenderId = null;
                        if (conversations.data.length > 0) {
                            for (var i = 0; i < conversations.data.length; i++) {
                                var sender_id = conversations.data[i].sender_id;
                                var sender_name = conversations.data[i].sender_name;
                                var sender_image = conversations.data[i].sender_image;
                                var receiver_id = conversations.data[i].receiver_id;
                                var receiver_name = conversations.data[i].receiver_name;
                                var receiver_image = conversations.data[i].receiver_image;
                                var message = conversations.data[i].content;
                                var timestamp = conversations.data[i].timestamp;
                                var conversationId = conversations.data[i].message_id;
                                var userId = conversations.data[i].auth_user;

                                // Placeholder image logic (if the image is null or empty, use a default avatar)
                                var senderAvatar = sender_image ? `<img src="${base_url + 'img/uploads/' + sender_image}" class="rounded-full h-10 w-10">` : `<div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 text-white capitalize">${sender_name[0]}</div>`;
                                var receiverAvatar = receiver_image ? `<img src="${base_url + 'img/uploads/' + receiver_image}" class="rounded-full h-10 w-10">` : `<div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 text-white capitalize">${receiver_name[0]}</div>`;

                                // Display the chat message for sender or receiver
                                var template = `
                                    <div class="conversation_item ${sender_id == userId ? 'col-start-6 col-end-13': 'col-start-1 col-end-8'} m-3 rounded-lg">
                                        <div class="group flex items-center ${sender_id == userId ? 'flex-row-reverse justify-start' : 'flex-row'}">
                                            <a href="${base_url + 'users/profile?uid=' + sender_id}">
                                            ${senderAvatar}
                                            </a>
                                            <div class="relative text-sm ${sender_id == userId ? 'bg-indigo-100 mr-3' : 'bg-white ml-3'} py-2 px-4 shadow rounded-xl max-w-[80%]">
                                                <div>${message}</div>
                                            </div>
                                        ${sender_id == userId ? `<div class="relative top-[-15px] deleteContainer">
                                                <button class="deleteBtn ellipsis-btn flex items-center justify-center bg-gray-200 rounded-full w-8 h-8 absolute top-0 transform opacity-0 ${sender_id == userId ? 'translate-x-10 group-hover:translate-x-0 mr-2 right-0' : 'translate-x-0 group-hover:translate-x-10 right-[36%]'} group-hover:opacity-100 transition-transform duration-300" data-mid="${conversationId}">
                                                    <svg class="w-4 h-4 fill-red-600"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                                </button>
                                            </div>` : ''}
                                        </div>
                                    </div>`;
                                // Prepend the message to the chat container
                                chatHTML = template + chatHTML;
                            }
                            // Display the receiver details above the chat container
                            var templateDetails = `
                                <div class="col-start-1 col-end-8 py-3 pr-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <a href="${base_url + 'messages'}" class="relative mr-3 text-lg hover:bg-slate-500 rounded-full flex items-center cursor-pointer">
                                            <svg width="10" height="40" viewBox="0 -9 3 24" class="text-slate-400 hover:text-slate-100 -rotate-180 w-10"><path d="M0 0L3 3L0 6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg>
                                        </a>
                                         <a class="flex flex-row items-center" href="${base_url + 'users/profile?uid=' + receiver_id}">
                                            ${receiverAvatar}
                                             <div class="relative mr-3 text-lg py-2 px-4">
                                                <div>${receiver_name}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>`;
                            $('.conversation_details').html(templateDetails);
                            // Prepend new messages to the conversation box
                            $('.conversation_box').prepend(chatHTML);

                            // Update offset by adding the limit (number of items loaded)
                            offset += limit;

                            // Resolve with the updated offset
                        }
                        resolve({
                            offset: offset,
                            conversations: conversations
                        });

                    }
                })
            });
        }


    })
</script>