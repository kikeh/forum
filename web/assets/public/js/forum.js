$('#upload').on('click', function (event) {
    event.preventDefault();

    var createPostUrl = Routing.generate('create_post');
    var threadId = $('.thread-box').attr('id');

    var replyTitle = $('#reply-title').val();
    var replyFile = new FormData($("#reply-file")[0].files[0]);
    console.log(replyFile);

    // Create post
    $.post( createPostUrl,
        JSON.stringify({
            'threadId' : threadId,
            'title' : replyTitle,
            'file' : replyFile
        }),
        function(data) {
            console.log(data);
        },
        'json'
    );


    // Reload page
    location.reload();
});
