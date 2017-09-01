 <!DOCTYPE html>
 <html>
 <head>
     <title>Teste Chatbot</title>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <link rel="stylesheet" href="style.css" />
	 <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	 <script type="text/javascript">
		$().ready(function(){
			$("#mensagem").submit(function(){
					
				if($("#mensagem #texto").val() === ""){
					
					$(".mensagens").animate({scrollTop: $("#chat").height()});
					setTimeout(function(){
						$("#chat").append("<div class='texto chatbot'>Por favor, digite uma mensagem para prosseguir.</div>");
						$(".mensagens").animate({scrollTop: $("#chat").height()});
					},1000);
					return false;
				}
				
				
				$.ajax({
					type: "POST",
					url: "conversa.php",
					data: {texto: $("#mensagem #texto").val(), 
						   id: 1},
					dataType: 'json', 
					beforeSend: function(){					
						$("#chat").append("<div class='texto usuario'>" + $("#mensagem #texto").val() + "</div>");	
					},
					success: function(resposta){
					  	$("#mensagem #texto").val("");
						$("#mensagem #texto").focus();
						
						if(resposta.error){
							$("#chat").append("<div class='texto chatbot'>" + resposta.error + "</div>");
							return false;
						}
						
						var mensagemChatbot  = "<div class='texto chatbot'>";
						mensagemChatbot		+= resposta.output.text[0];
						mensagemChatbot		+= "</div>";
						setTimeout(function(){
							$("#chat").append(mensagemChatbot);
							$(".mensagens").animate({scrollTop: $("#chat").height()});
						},1000);
					}
				});

				return false;
			});
		});
	</script>
 </head>
 <body>
 
	<div id="box" class="box">
		<div class="mensagens">
			<div class="area" id="chat">
			</div>
		</div>
		<form id="mensagem" class="mensagem">
			<input type="text" id="texto" name="texto" placeholder="Digite uma mensagem"/>
			<button type="submit">Enviar</button>
		</form>
	</div>
 
 </body>
 </html>