 function getApiTokenFromDom() {
      return document.getElementById('api_token').value
 }
 
 let post = (url, params = {}, token = getApiTokenFromDom()) => {
   if (!token) token = '' 
   return fetch('/api'+url,{
        headers: {
               'Accept': 'application/json',
               'Content-Type': 'application/json',
               'Authorization' : 'Bearer ' + token
        },
        method:'POST',
        body:JSON.stringify(params),
   }).then(response=>response.json())
}

let get = (url, params = {}, token = getApiTokenFromDom()) => {
     if (!token) token = ''
     return fetch('/api' + url, {
          headers: {
               'Accept': 'application/json',
               'Content-Type': 'application/json',
               'Authorization' : 'Bearer ' + token
        },
        method:'GET'
     }).then(response => response.json())
}

let put = (url, params = {}, token = getApiTokenFromDom()) => {
     if (!token) token = ''
     return fetch('/api' + url, {
          headers: {
               'Accept': 'application/json',
               'Content-Type': 'application/json',
               'Authorization' : 'Bearer ' + token
        },
        method:'PUT',
        body:JSON.stringify(params),
     }).then(response => response.json())
}

let getPdf = (url, params = {}, token = getApiTokenFromDom()) => {
     if (!token) token = ''
     return fetch('/api' + url, {
          headers: {
               'Accept': 'application/pdf',
               'Content-Type': 'application/json',
               'Authorization' : 'Bearer ' + token
        },
        method:'POST',
        body:JSON.stringify(params),
     }).then(response => response.blob())
}

export {post, get, put, getPdf}