var getNextContent = function ($from) {
    $.ajax({
        url: '/rest/allPosts',
        method: 'POST',
        data: {from: $from}
    }).done(function (data) {
        $.each(data, function (i, value) {
            var element = "<li class='article-list'>" +
                "<article class='col-md-12 current-a'>" +
                "<h1>" + value.title + "</h1>" +
                "<p>№" + ($from + 1 + i) + "</p>" +
                "<span>By <a href='/user/profile/" + value.user_name + "'>" + value.user_name + "</a></span>" +
                "<span>" + value.created + "</span>" +
                "<p>" + value.body + "</p>" +
                "<a href='/article/" + value.id + "' class='btn btn-default btn-sm'>read more</a>" +
                "</article>" +
                "</li>";
            $(element).appendTo('.col-md-12.no-bullet');
        });
    });
};

getNextContent(0);
var i = 10;
$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() === $(document).height()) {
        getNextContent(i);
        i += 10;
    }
});