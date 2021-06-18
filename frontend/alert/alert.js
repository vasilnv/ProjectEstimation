function notify(message){
  console.log(message);
  if(message.message){
    alert(message.message);    
  } else {
    alert(message);
  }
}
