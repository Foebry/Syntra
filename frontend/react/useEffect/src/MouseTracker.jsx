import { useEffect, useState } from "react";

const MouseTracker = (handleMouseMove) => {
    const [position, setPosition] = useState({ x: 0, y: 0 });
    // const handleMouseMove = window.addEventListener("mousemove", (e) =>
    //     setPosition({ x: e.clientX, y: e.clientY })
    // );
    //useEffect met lege array -> functie zal uitgevoerd worden "on mount" (als die voor de eerste keer geladen wordt)
    //useEffect(() => window.addEventListener("mousemove", handleMouseMove), []);
    return (
        <>
            <div>
                <h1>MouseTracker</h1>
                <p>x: {position.x}</p>
                <p>y: {position.y}</p>
            </div>
        </>
    );
};

export default MouseTracker;
