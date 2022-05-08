import { useState, useEffect } from "react";
import axios from "axios";

const url = "https://www.thecocktaildb.com/api/json/v1/1/filter.php?!=lemon";

const LemonCocktails = () => {
    const [cocktails, setCocktails] = useState([]); //fullfilled
    const [loading, setLoading] = useState(false); //pending
    const [error, setError] = useState(false); //rejected

    useEffect(() => {
        (async () => {
            try {
                setLoading(true);
                const {
                    data: { drinks },
                } = await axios(url);
                setLoading(false);
                setError(false);
                setCocktails(drinks);
            } catch (error) {
                setError(error);
                setLoading(false);
            }
        })();
    }, []);
    return (
        <div>
            <h1>List of Lemon Cocktails</h1>
            {error && <p>NEN ERROR</p>}
            {loading && <p>LOADING</p>}
            {cocktails.length > 0 && (
                <ul>
                    {cocktails.map(({ idDrink, strDrink }) => (
                        <li key={idDrink}>{strDrink}</li>
                    ))}
                </ul>
            )}
        </div>
    );
};

export default Cocktails;
