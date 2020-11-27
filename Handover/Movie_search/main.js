function hideFields(){
    document.getElementById("divFullName").remove();
    document.getElementById("divMonthlyNews").remove();
    document.getElementById("divBreakNews").remove();
    document.getElementById("divSubscribeButton").remove();
    document.getElementById("divUnsubscribeLink").remove();

    document.getElementById("h2Title").innerText = "Unsubscribe to our newsletter";

    const div = document.createElement('div');
    div.className = "row";
    div.id = "divUnSubscribeButton";
    div.innerHTML = '<input type="submit" name="unsubscribe" value="Unsubscribe">';
    document.getElementById('mainForm').appendChild(div);

    
}
