 import {getCookie} from './cookies'
 
 let post = (url, params = {}, token = getCookie('api_token')) => {
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

let get = (url, params = {}, token = getCookie('api_token')) => {
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

let put = (url, params = {}, token = getCookie('api_token')) => {
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

export {post, get, put}