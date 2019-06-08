function correct ()
{
    var text = document.getElementById('text-input').value;

    const request = new XMLHttpRequest();

    request.onreadystatechange = function(event) {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            document.getElementById('text-output').innerText = this.responseText;
        }
    };

    request.open('GET', 'correct.php?text='+encodeURI(text), true);
    request.send(null);
}

document.addEventListener('DOMContentLoaded', function() {
    M.Modal.init(document.getElementById('about'), {});
});
