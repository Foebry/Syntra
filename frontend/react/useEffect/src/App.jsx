import { useEffect, useState } from "react";
// import MouseTracker from "./MouseTracker";
// import LemonCocktails from "./LemonCocktails";
import SearchCocktail from "./SearchCocktail";
const App = () => {
    const [isVisible, setIsVisible] = useState(false);
    return (
        <>
            <h1>Onze React App</h1>
            <SearchCocktail />
            {/* <button
                onClick={() => {
                    setIsVisible(!isVisible);
                    window.removeEventListener("mousemove", handleMouseMove);
                }}
            >
                Toggle MouseTracker
            </button> */}
            {/* {isVisible && <MouseTracker handleMouseMove />}
            <LemonCocktails /> */}
        </>
    );
};

export default App;
