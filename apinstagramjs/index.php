<!DOCTYPE html>
<html>
    <body>

        <div id="demo"></div>

        <script>
            widgetInstagram = function () {
                opt = null;
                ul_css = function () {
                    var width = opt.hasOwnProperty("width") ? opt.width : "100%";
                    var css = {
                        "width": width,
                        "list-style-type": "none",
                        "list-style-position": "none",
                        "list-style-image": "none"
                    };
                    return css;
                };

                li_css = function () {
                    var css = {"float": "left",
                        "padding": "0",
                        "width": "calc(100%/" + opt.col + ")",
                        "background": "#fff",
                        "text-align": "center"
                    };
                    return css;
                };

                img_css = function () {
                    var css = {
                        "width": "97%",
                        "padding-bottom": "3%",
                        "margin-left": "auto",
                        "margin-right": "auto"
                    };
                    return css;
                };

                p_css = function () {
                    var css = {
                        "width": "100%",
                        "float": "left"
                    };
                    return css;
                };

                createDOM = function (data) {
                    var aside = document.createElement("aside");
                    var p = document.createElement("p");

                    if (data.hasOwnProperty("error_type")) {
                        //ERROR
                        var text_error = document.createTextNode(data.error_message);
                        p.appendChild(text_error);
                    } else {
                        var h2 = document.createElement("h2");
                        var h2_text = document.createTextNode("En Instagram");
                        h2.appendChild(h2_text);

                        var ul = document.createElement("ul");
                        var ul_css_value = ul_css();
                        for (var prop in ul_css_value) {
                            ul.style[prop] = ul_css_value[prop];
                        }

                        for (var index in data) {
                            if (data.hasOwnProperty(index)) {
                                var img = document.createElement("img");
                                img.title = data[index].caption !== null && data[index].caption.hasOwnProperty("text") ? data[index].caption.text : "";
                                img.alt = data[index].caption !== null && data[index].caption.hasOwnProperty("text") ? data[index].caption.text : "";
                                img.src = data[index].images.thumbnail.url;
                                img.style.maxWidth = data[index].images.thumbnail.width + "px";
                                var img_css_value = img_css();
                                for (var prop in img_css_value) {
                                    img.style[prop] = img_css_value[prop];
                                }

                                var a_li = document.createElement("a");
                                a_li.target = "_blank";
                                a_li.href = data[index].link;
                                a_li.appendChild(img);

                                var li = document.createElement("li");
                                var li_css_value = li_css();
                                for (var prop in li_css_value) {
                                    li.style[prop] = li_css_value[prop];
                                }
                                li.appendChild(a_li);

                                ul.appendChild(li);
                            }
                        }

                        var a_p_text = document.createTextNode("S\u00EDguenos");

                        var a_p = document.createElement("a");
                        a_p.target = "_blank";
                        a_p.href = "//instagram.com/" + data[0].user.username;
                        a_p.appendChild(a_p_text);

                        p.appendChild(a_p);
                        var p_css_value = p_css();
                        for (var prop in p_css_value) {
                            p.style[prop] = p_css_value[prop];
                        }

                        aside.appendChild(h2);
                        aside.appendChild(ul);
                    }
                    aside.appendChild(p);

                    return aside;
                };

                this.jsonp = function (options, callback) {
                    opt = options;
                    var col = opt.hasOwnProperty("col") ? opt.col : 1;
                    var fill = opt.hasOwnProperty("fill") ? opt.fill : 1;
                    var count = col * fill;
                    var url = opt.url + "&count=" + count;

                    var callbackName = 'jsonp_callback_' + Math.round(100000 * Math.random());
                    window[callbackName] = function (response) {
                        delete window[callbackName];
                        document.body.removeChild(script);
                        var value;
                        if (response.meta.code === 200) {
                            value = response.data;
                        } else {
                            value = response.meta;
                        }
                        var element = createDOM(value);
                        callback(element);
                    };

                    var script = document.createElement('script');
                    script.src = url + (url.indexOf('?') >= 0 ? '&' : '?') + 'callback=' + callbackName;
                    document.body.appendChild(script);
                };
            };

            execInstagram = function () {
                if (typeof widgetInstagram === 'undefined') {
                    return;
                }
                var self = new widgetInstagram();
                var options = {url: "https://api.instagram.com/v1/users/self/media/recent/?access_token=2330689767.d264f46.f84714a9390e4770890a10842d8ed67e",
                    col: 5,
                    fill: 10,
                    width: "250px"
                };
                self.jsonp(options, function (response) {
                    var element = document.getElementById("demo");
                    element.appendChild(response);
                });
            };

            document.addEventListener('DOMContentLoaded', function () {
                execInstagram();
            }, false);

        </script>

    </body>
</html>
