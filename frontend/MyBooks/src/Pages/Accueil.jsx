import { NavLink } from "react-router-dom"
import axios from "axios";
import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { SearchBook } from "../Components/SearchBook";


export const Accueil = ()=> {
    const [message, setMessage] = useState('');
    const [isConnected, setIsConnected] = useState(false);
    const [userData, setUserData] = useState({});
    const navigate = useNavigate();

    useEffect(()=>{
        verifyConnect();
    },[]);

    const handleLogout = async ()=>{

        const response = await axios.post('http://localhost:8888/logout', {},{withCredentials: true});
        if(response.data.code === 200){
            setMessage(response.data.message);
            setIsConnected(false);
            setTimeout(()=>{
                navigate('/Accueil');
            }
            ,1000);
            setMessage('');

        }else {
            setMessage(response.data.message);
        }
    }

    const verifyConnect = async ()=>{

        const response = await axios.post ("http://localhost:8888/checkAuth", {}, {withCredentials: true});
        if(response.data.authenticated){
            setUserData(response.data.user);
            setIsConnected(true);
            
            
        } else {
            setIsConnected(false);
        }
    }

    return (
        <div>
        <h1>Bienvenue</h1>
        {isConnected ? <div>
            <button onClick={handleLogout}>Se déconnecter</button>
            <NavLink to="/MyAccount">Mon compte</NavLink>
            </div> 
        : <NavLink to="/ConnectAccount">Se connecter</NavLink>}
        <NavLink to="/MyLibrary">Ma bibliothèque</NavLink>
        {message && <p>{message}</p>}

        <SearchBook isConnected={isConnected}/>



        </div>
    )
}