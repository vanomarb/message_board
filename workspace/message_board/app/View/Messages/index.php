<div class="container mx-auto mt-32 px-32">
  <div class="flex justify-between my-10">
    <?php
    echo $this->Form->input('search', [
      'label' => '',
      'class' => 'border rounded-md p-2 w-full searchMessage',
      'placeholder' => 'Search message'
    ]);
    ?>
    <a href="<?= $this->webroot . 'messages/new_message' ?>" class="p-2 bg-blue-700 rounded-md text-white shadow-lg shadow-slate-400 hover:bg-blue-800 hover:text-slate-200">
      New message
    </a>
  </div>
  <p class="text-2xl text-bold text-center">Message List</p>
  <ul role="list" class="messageListContainer divide-y divide-gray-100 mt-10">

  </ul>

</div>
<script>
  $(document).ready(function() {
    var offset = 0;
    var limit = 6;
    var search = '';

    
    $('.searchMessage').keyup(debounce(function() {
      search = $(this).val().toLowerCase();
      offset = 0;
      $('.messageListContainer').html('');
      showList(offset, limit, search).then(function() {
        $('.messageItem').addClass('delay-150 scale-100');
        $('.messageItem').on('transitionend', function() {
          $('.messageItem').removeClass('scale-0');
        });
      });
    },200));

    function showList(offset, limit, search = '') {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${base_url}messages/getMessagesList`,
          type: "GET",
          data: {
            offset,
            limit,
            search
          },
          success: function(response) {
            const res = JSON.parse(response);

            if (res.status === "success") {
              handleSuccess(res.data, offset, limit, resolve);
            } else {
              resolve(offset); // Resolve even on error for continuity
            }
          },
          error: function(err) {
            reject(err);
          }
        });
      });
    }

    function handleSuccess(messages, offset, limit, resolve) {
      if (messages.length === 0) {
        handleNoMessages(offset, resolve);
        return;
      }

      const template = messages.map(buildMessageTemplate).join('');
      $('.messageListContainer').append(template);
      resolve(offset + limit); // Update and resolve with new offset
    }

    function handleNoMessages(offset, resolve) {
      const messageContainer = $('.messageListContainer');

      if (messageContainer.find('.emptyMessage').length === 0) {
        messageContainer.append(`
      <li class="emptyMessage flex justify-center py-5 text-center items-center">
        No more messages to load.
      </li>
    `);
      }

      resolve(offset); // Resolve with current offset
    }

    function buildMessageTemplate(message) {
      if (!message.content) return '';

      const receiverAvatar = message.receiver_image ?
        `<img src="${base_url + 'img/uploads/' + message.receiver_image}" class="h-12 min-w-12 flex-none rounded-full bg-gray-50">` :
        `<div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-500 text-white capitalize">${message.receiver_name[0]}</div>`;

      return `
    <li class="messageItem group flex justify-between gap-x-6 p-5 hover:bg-slate-100 cursor-pointer transition-all duration-150 ease-out scale-0" data-id="${message.receiver_id}">
      <div class="flex min-w-0 gap-x-4 w-full">
        ${receiverAvatar}
        <div class="max-w-[85%] flex-auto">
          <p class="text-sm font-semibold leading-6 text-gray-900">${message.receiver_name}</p>
          <p class="mt-1 truncate text-xs leading-5 text-gray-500">${message.content}</p>
        </div>
      </div>
      <div class="group/showBtn hidden shrink-0 sm:flex sm:flex-col sm:items-end relative">
        <p class="text-xs leading-6 text-gray-900">${message.receiver_email}</p>
        <p class="mt-1 text-xs leading-5 text-gray-500 group-hover/showBtn:hidden">${message.timestamp}</p>
        <p class="mt-1 text-xs leading-5 text-gray-500 hidden group-hover/showBtn:flex">${message.date_added}</p>
      </div>
      ${buildDeleteButton()}
    </li>
  `;
    }

    function buildDeleteButton() {
      return `
    <div class="relative top-[2%] deleteContainer">
      <button class="deleteBtn ellipsis-btn flex items-center justify-center bg-gray-200 rounded-full w-8 h-8 absolute right-[36%] top-0 transform opacity-0 translate-x-0 group-hover:translate-x-14 group-hover:opacity-100 transition-transform duration-300">
        <svg class="w-4 h-4 fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
          <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
        </svg>
      </button>
    </div>
  `;
    }


    showList(offset, limit, search).then(function(newOffset) {
      offset = newOffset; // Update the offset after initial load
      $('.messageItem').addClass('delay-150 scale-100');
      $('.messageItem').on('transitionend', function() {
        $('.messageItem').removeClass('scale-0');
      });

      $(window).on('scroll', function() {
        // Check if at the bottom of the container
        if ($(this).scrollTop() + $(this).innerHeight() >= $(document).height()) {
          showList(offset, limit, search).then(function(newOffset) {
            offset = newOffset; // Update offset after loading more messages
          });
        }
      });
    });

    $(document).on('click', '.messageItem', function() {
      var id = $(this).data('id');
      window.location.href = base_url + 'messages?conversation_id=' + id;
    });

    $(document).on('click', '.deleteContainer', function(e) {
      e.stopPropagation(); // Stop the click event from propagating to the parent .messageItem

      var conversation_id = $(this).parents('.messageItem').data('id');
      var confirmation = confirm('Are you sure you want to delete this message?');
      var self = $(this); // Store reference to 'this'

      if (confirmation) {
        $.ajax({
          url: base_url + 'messages/deleteMessages',
          type: 'POST',
          data: {
            conversation_id: conversation_id
          },
          success: function(response) {
            var res = JSON.parse(response);
            if (res.status === "success") {
              self.closest('.messageItem').removeClass('scale-100').addClass('scale-0');
              // Listen for the transition end event
              self.closest('.messageItem').on('transitionend', function() {
                showList(); // Call showList after the transition
              });
            } else {
              alert(res.message);
            }
          }
        });
      }
    });



  })
</script>