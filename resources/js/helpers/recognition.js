export let rec = ((e) => {
    let recognition = new webkitSpeechRecognition()
    recognition.started = false
    recognition.lang = 'lt-LT'
    recognition.onstart =  () => {
        recognition.started = true;
        e.target.classList.add('active')
    }
    
    recognition.onresult = event => {
        document.getElementById('search').value = event.results[0][0].transcript;
    }
    
    recognition.onend = () => {
        recognition.started = false;
        e.target.classList.remove('active')
        document.getElementById('search').dispatchEvent(new Event('change'))
    }
    
    recognition.onerror = event => {
        recognition.started = false;
    }

    return recognition
})