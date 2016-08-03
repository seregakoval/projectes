		<script type="text/javascript" src="##PLUGINDIR##/S3MediaVault/flowplayer-3.1.2.min.js"></script>
	
        <div id="player##ID##" style="width:##WIDTH##px; height:##HEIGHT##px"></div>
            <script type="text/javascript">
                flowplayer("player##ID##", "##PLUGINDIR##/S3MediaVault/flowplayer-3.1.2.swf", { 
                    clip: { 
                        url: escape('##FILE##'), 
                        autoPlay: ##AUTOPLAY##, 
                        autoBuffering: ##AUTOBUFFERING##
                    }
                });			
            </script>
