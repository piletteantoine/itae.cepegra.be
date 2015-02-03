<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="copyright" content="ITAE - Imperial Trans-Antartic Expedition">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="icon" type="image/png" href="images/favicon.png" />
        <title>Impérial trans-Antarctic Expedition</title>
    </head>
<body class="body__expedition">
<div class="sidebar">
    <input type="checkbox" id="burgerbtn" name="burgerbtn" checked>
    <label for="burgerbtn" class="burgerlabel" ></label>
    <ul class="menu_expedition">
        <li><a href="index">Home</a></li>
        <li><a href="expedition">Expedition</a></li>
        <li><a href="preparation">Preparation</a></li>
        <li><a href="crew">Crew</a></li>
    </ul>
</div>
<section>
    <div class="scroll"></div>
    <div id="mapping_container">
        <div id="scroll_container">
            <svg id="mapping"></svg>
            <div id="scroll"></div>
        </div>
    </div>
    <div class="pointInfo__Container">
        <a class="streetView" href="#">Actually</a>
        <a class="history" href="#">History</a>
    </div>
    <div id="streetView">
    </div>
    <div id="history">
    </div>
</section>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="js/vendor/snap.svg-min.js"></script>
<script>
(function ($){

    var datajson,
        step = false;

    function OpenStep(emplacement){
        if(!step) {
        console.log('OpenStep');
            myEmplacement = datajson[emplacement];
            $('#place').attr('style', 'opacity:1');
            $('.pointInfo__Container').slideToggle('slow');
            $('#place, .history').on('click', function(){
                //console.log('#place');
                var crew = ''; 
                crew += '<span class="close">x</span>';
                crew += '<img id="mobile__crew" src="images/map/'+ myEmplacement['id'] +'.jpg"/>';
                crew += '<div class="right__side">';
                crew += '<h1>' + myEmplacement['hstry_location']+ '</h1>';
                crew += '<h2>' + myEmplacement['hstry_subtitle']+ '</h2>';
                crew += '<p>' + myEmplacement['hstry_text']+ '</p>';
                crew += '<button id="goView" class="btn btn_green">Google Street View</button>';
                crew += '</div>';
                crew += '<div class="left__side" style="background:url(images/map/'+ myEmplacement['id'] +'.jpg) no-repeat top left;">';
                crew += '</div>';

                $("#history")
                    .html(crew)
                    .removeClass()
                    .addClass(emplacement)
                    .show();
            });

            $('.streetView').on('click', function(){

                var crew = '';
                    crew += '<span class="close">x</span>';
                    crew += '<div class="right__side">';
                    crew += '<h1>' + myEmplacement['hstry_location']+ '</h1>';
                    crew += '<h2>' + myEmplacement['contemp_subtitle']+ '</h2>';
                    crew += '<p>' + myEmplacement['contemp_text']+ '</p>';
                    crew += '<button id="goHistory" class="btn btn_blue">History</button>';
                    crew += '</div>';
                    crew += '<div class="left__streetView">';
                    crew += '<div id="pano">';
                    crew += '</div>';
                    crew += '</div>';
                $("#streetView")
                    .html(crew)
                    .removeClass()
                    .addClass(emplacement)
                    .show();

                    var viewPlace = new google.maps.LatLng(myEmplacement['k'],myEmplacement['b']);
                    console.log(viewPlace);
                    var panoramaOptions = {
                        position: viewPlace,
                        visible: true
                      };
                    var panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'), panoramaOptions);

            });
            step = true;
        }
    }

    //JSON Query
    $.getJSON('map.json',function(data){
        //console.log(data);
        datajson = data;
        });
        //console.log(crew);


    var s = new Snap('#mapping');
    var vBoxLargeur = 425.2 * 2;
    var vBoxHauteur = 354.33 * 2;
    var posBoatL = vBoxLargeur/2;
    var posBoatH = vBoxHauteur/2;
    var posPlaceL = posBoatL + 60;
    var posPlaceH = posBoatH - 40;
    s.attr({
        viewBox: [0, 0, vBoxLargeur, vBoxHauteur]
    });
    Snap.load("images/trajectoire.svg", function (f){
        function getShift(dot) {
            return "t" + (posBoatL - dot.x) + "," + (posBoatH - dot.y);
             
        }
        var all = f.select("#map"),
            boat = f.select("#boat"),
            start = f.select("#start"),
            place = f.select("#place"),
            end = f.select("#end"),
            pth = f.select("#path"),
            ant = f.select("#antartic"),
            travel,
            len,
            bg = s.g();
        bg.append(all);

        pth.attr({
            display:"none",
        });
        start.attr({
            display:"none",
        })

        end.attr({
            display:"none",
        });
        boat.appendTo(s);
        boat.attr({
            transform: 't' + posBoatL + ',' + posBoatH
        });
        place.appendTo(s);
        place.attr({
            transform: 't' + posPlaceL + ',' + posPlaceH,
            opacity:0,
        });
        bg.attr({
            transform: getShift({
                x: start.getBBox().cx,
                y: start.getBBox().cy
            })
        });

        travel = all.path().attr({
            fill: "none",
            stroke: "#99F9C8",
            strokeWidth : 5,
            strokeDasharray: "7 5"
        }).insertAfter(pth);

        len = Snap.path.getTotalLength(pth.attr("d"));

        $('#scroll_container').on('scroll', function(e) {
            // ratio totalLength vs max range
            var scrollContainerHeight = $('#scroll_container').height(),
                scrollHeight = $('#scroll').height(),
                l = len * $(this).scrollTop() / (scrollHeight - scrollContainerHeight),
            // get point at "partial" length
                dot = pth.getPointAtLength(l);

            // keep SVG on top
            $('#mapping').css('top', $(this).scrollTop());
            console.log(l, $(this).scrollTop()/10);
            $('#scroll_container').scroll(function(){
                if ($(this).scrollTop() > 0) {
                   $('.scroll').hide();
                }else {
                $('.scroll').show();
                }
            });

            // draw travel path
            travel.attr({
                d: pth.getSubpath(0, l)
            });

            // move and rotate the background
            bg.attr({
                transform: getShift(dot) +
                           'r' + (270 - dot.alpha) + ',' + dot.x + ',' + dot.y
            });

            if (l > 135 && l < 300) {
                OpenStep('hstry_grytviken');
            }else if(l > 850 && l < 1000) {
                OpenStep('hstry_packice');
            }else if(l > 3000 && l < 3300) {
                OpenStep('hstry_trap');
            }else if(l > 4500 && l < 4800) {
                OpenStep('hstry_sank');
            }else if(l > 4900 && l < 5100) {
                OpenStep('hstry_camp');
            }else if(l > 5700 && l < 5850) {
                OpenStep('hstry_elephant');
            }else if(l > 6300 && l < 6600) {
                OpenStep('hstry_lifeboat');
            }else if(l > 8550 && l < 9000) {
                OpenStep('hstry_stromness');
            }else {
                place.attr({
                    opacity:0,
                });
                $('.pointInfo__Container').slideUp(500);
                $('#place, .history, .streetView').off('click');
                step = false;
            };
        });
    });s
    $(document).on('click', '.close', function(){
        $(this).parent('div').removeClass().hide();
    });
    $(document).on('click', '#goHistory', function(){
        // $(this).closest('#streetView').hide();
        $(this).closest('#streetView').hide(0,function(){
            $('a.history').trigger('click');
        });
    });
     $(document).on('click', '#goView', function(){
        // $(this).closest('#streetView').hide();
        $(this).closest('#history').hide(0,function(){
            $('a.streetView').trigger('click');
        });
    });
    $('#burgerbtn').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('burgercheck');
    });
}(jQuery));
</script>
</body>
</html>
