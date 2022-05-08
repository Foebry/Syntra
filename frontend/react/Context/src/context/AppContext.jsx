import React, { createContext, useState } from "react";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
  const [friends, setFriends] = useState([
    { id: 2, name: "Koen" },
    { id: 3, name: "Johan" },
    { id: 4, name: "Kevin B." },
    { id: 5, name: "Kevin" },
    { id: 6, name: "Valerie" },
    { id: 7, name: "Brahim" },
    { id: 8, name: "Eva" },
  ]);

  return (
    <AppContext.Provider
      value={{
        setFriends,
        user: {
          id: 1,
          name: "Sander",
          vrienden: friends,
        },
      }}
    >
      {children}
    </AppContext.Provider>
  );
};

export default AppProvider;
