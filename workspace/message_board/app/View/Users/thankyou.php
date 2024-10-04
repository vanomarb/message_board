<div class="bg-[#ebecef] h-screen">
    <div class="container flex flex-col w-3/6 m-auto pt-10 rounded-md items-center">
        <?= $this->HTML->image('success.gif', array(
            'class' => 'p-2 flex justify-center items-center'
        )) ?>
        <h1 class="text-emerald-600 text-2xl text-center -mt-14">Registration successful!</h1>
        <a href="/message_board/messages" class="p-2 flex justify-center items-center bg-blue-400 hover:bg-blue-500 rounded-md text-white mt-4 w-48">Back to homepage</a>
    </div>
</div>