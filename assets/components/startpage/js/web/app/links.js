define(["app","sortable","autocomplete"],function(n,i,t){"use strict";jQuery=$,n.Links={init:function(){$(document).on("click",".link-header span",function(){var i=$(this),t=i.parents(".link"),e=t.data("id");i.hasClass("remove")?n.Links.remove(e):n.Links.update(e)}),n.Router.route("add","add",function(){n.Links.add()}),$("#links").on("sortupdate",function(i){var t=i.detail.oldindex,e=i.detail.index,o=$(i.detail.item).data("id");$.post(n.action_url,{action:"link/sort",from:t,to:e,id:o},"json")}),this.sortable()},add:function(){n.Modal.load("link/get",{},function(){t({Url:n.action_url+"?action=link/search",_Cache:function(){}},"#new-link-form-input")})},update:function(i){var t=$("#link-"+i);t.addClass("loading"),$.ajax(n.action_url,{method:"post",data:{action:"link/update",id:i},dataType:"json",success:function(n){_.isEmpty(n.object.content)||t.replaceWith(n.object.content)},error:function(i){i=i.responseJSON,_.isEmpty(i.message)||n.Message.failure(i.message),t.removeClass("loading")}})},remove:function(i){var t=$("#link-"+i);$.post(n.action_url,{action:"link/remove",id:i},function(n){t.remove()},"json")},sortable:function(){i("#links",{items:":not(#new-link)",placeholderClass:"link placeholder"})},formCallback:function(i){if(n.Modal.hide(),!_.isEmpty(i.content)){var t=$(i.content);t.insertBefore($("#new-link")),t.find(".link-image img").length||n.Links.update(i.id),n.Links.sortable()}}},n.Links.init()});