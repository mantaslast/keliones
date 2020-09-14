export let rec = ((e) => {
    let recognition = new webkitSpeechRecognition()
    recognition.started = false
    recognition.lang = 'lt-LT'
    recognition.onstart =  () => {
        recognition.started = true;
        e.target.classList.add('active')
    }
    
    recognition.onresult = event => {
        e.target.previousElementSibling.previousElementSibling.value = event.results[0][0].transcript;
    }
    
    recognition.onend = () => {
        recognition.started = false;
        e.target.classList.remove('active')
    }
    
    recognition.onerror = event => {
        recognition.started = false;
    }

    return recognition
})