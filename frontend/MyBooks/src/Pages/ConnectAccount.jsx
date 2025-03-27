import { useState } from "react"
import { useNavigate } from "react-router-dom"

import axios from 'axios'

export const ConnectAccount = ()=> {
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [message, setMessage] = useState('')
    const navigate = useNavigate()


    const handleSubmit = async (e) => {
        e.preventDefault() 

        const response = await axios.post('http://localhost:8888/login', {email, password}, { 
            headers: { "Content-Type": "application/json" },
            withCredentials: true
        })
        
        if(response.data.code === 200){
            setMessage(response.data.message)
            setTimeout(() => {
                navigate('/Accueil')
            }, 1000)
        } else {
            setMessage(response.data.message)
        }
        

        
    }
    return (
        <div>
            <h1>Connexion au compte</h1>
            <form onSubmit={handleSubmit}>
                <div>
                    <label htmlFor="email">Votre email</label>
                    <input type="mail" id="email" name="email" required onChange={(e)=>setEmail(e.target.value)}/>
                </div>
                <div>
                    <label htmlFor="password">Votre mot de passe</label>
                    <input type="password" id="password" name="password" required onChange={(e)=>setPassword(e.target.value)}/>
                </div>
                <button type="submit">Se connecter</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    )
}