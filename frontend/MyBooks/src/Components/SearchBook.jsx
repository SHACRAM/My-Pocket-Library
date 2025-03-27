import React, { useState, useEffect } from "react";
import axios from "axios";

export const SearchBook = ({isConnected}) => {
    const [searchTerm, setSearchTerm] = useState('');
    const [searchResults, setSearchResults] = useState([]);
    const [message, setMessage] = useState('');

    const addToCollection = async (book) => {
        try{
            const name = book.volumeInfo.title;
            const author = book.volumeInfo.authors?.join(", ") || "Auteur inconnu";
            const image = book.volumeInfo.imageLinks?.thumbnail;
            const isbn = book.volumeInfo.industryIdentifiers[0]?.identifier || "ISBN non disponible";
            const payload = {name, author, image, isbn};

            const response = await axios.post("http://localhost:8888/addToCollection", {payload}, {withCredentials: true});

            if(response.data.code === 201){
                setMessage(response.data.message);
                setTimeout(()=>{
                    setMessage('');
                },1000);
            } else {
                setMessage(response.data.message);
            }



        }catch(error){
            setMessage("Erreur lors de l'ajout du livre à la collection");
        }


    }

    const searchApi = async () => {
        try {
            const response = await axios.get(`https://www.googleapis.com/books/v1/volumes?q=${searchTerm}`);
            setSearchResults(response.data.items || []); 
        } catch (error) {
            console.error("Erreur API :", error);
            setSearchResults([]);
        }
    };

    useEffect(() => {
        if (searchTerm === '') {
            setSearchResults([]); 
            return;
        }

        if (searchTerm.length > 3) {
            const delayDebounceFn = setTimeout(() => {
                searchApi();
            }, 500); 

            return () => clearTimeout(delayDebounceFn);
        }
    }, [searchTerm]);

    return (
        <div>
            <h1>Trouver un livre</h1>
            <div>
                <input 
                    type="search" 
                    placeholder="exemple : Le Seigneur des Anneaux" 
                    onChange={(e) => setSearchTerm(e.target.value)}
                />
            </div>
            {searchResults.length > 0 ? (
                <div>
                    {searchResults.map((book, index) => (
                        <div key={index}>
                            {book.volumeInfo.imageLinks?.thumbnail && (
                                <img src={book.volumeInfo.imageLinks.thumbnail} alt={book.volumeInfo.title} />
                            )}
                            <h2>{book.volumeInfo.title}</h2>
                            <p>{book.volumeInfo.authors?.join(", ") || "Auteur inconnu"}</p>
                            {book.volumeInfo.industryIdentifiers ? (
                            <p>ISBN : {book.volumeInfo.industryIdentifiers[0]?.identifier}</p>
                            ) : (
                            <p>ISBN non disponible</p>
                            )}
                            {isConnected && (
                                <button onClick={() => addToCollection(book)}>Ajouter à ma collection</button>
                            )}
                            {message && <p>{message}</p>}
                        </div>
                    ))}
                </div>
            ) : (
                <p>Aucun résultat</p>
            )}
        </div>
    );
};
