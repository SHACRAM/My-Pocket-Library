import React from "react";
import axios from "axios";
import {useNavigate} from "react-router-dom";
import { useState } from "react";

export const CreateAccount = () => {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState('');
    const navigate = useNavigate();


    const handleSubmit = async (e) => {
        e.preventDefault();
        const payload = { name, email, password };
        try {


            const response = await axios.post(
                "http://localhost:8888/createAccount",
                payload,
                { 
                    headers: { "Content-Type": "application/json" },
                    withCredentials: true
                }
            );
    
            if (response.data.code === 201) {
                setMessage(response.data.message);
                navigate("/ConnectAccount");
            }
        } catch (error) {
            console.error("Erreur lors de la création du compte :", error);
        }
    };
    



    return(
        <div>
            <h1>Créer un compte</h1>
            <div>
                <form  onSubmit={handleSubmit}>
                    <div>
                        <label htmlFor="name">Votre nom</label>
                        <input type="text" id="name" name="name" required onChange={(e)=>setName(e.target.value)}/>
                    </div>
                    <div>
                        <label htmlFor="email">Votre email</label>
                        <input type="mail" id="email" name="email" required onChange={(e)=>setEmail(e.target.value)} />
                    </div>
                    <div>
                        <label htmlFor="password">Votre mot de passe</label>
                        <input type="password" id="password" name="password" required onChange={(e)=>setPassword(e.target.value)}/>
                    </div>
                    <button type="submit">Créer mon compte</button>
                    {message && <p>{message}</p>}
                </form>
            </div>
        </div>
    )
}