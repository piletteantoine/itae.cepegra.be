"use strict";(function(e){var t=new Snap,n=425.2,r=354.33,i=n/2,s=n/2;t.attr({viewBox:[0,0,n,r]});Snap.load("images/trajectoire.svg",function(e){function i(e){return"t"+(n-e.x)+","+(r-e.y)}var s=e.select("#map"),o=e.select("#start"),u=e.select("#path"),a=e.select("#boat"),f,l,c=t.g();console.log(o);c.add(s);u.attr({display:"none"});a.appendTo(t);a.attr({transform:"t225,175"});c.attr({transform:i({x:o.attr("cx"),y:o.attr("cy")})})})})(jQuery);