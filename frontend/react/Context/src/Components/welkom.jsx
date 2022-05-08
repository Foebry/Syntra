import { useContext } from "react";
import { AppContext } from "../context/AppContext";

const Welkom = () => {
  const {
    user: { name, vrienden },
    setFriends,
  } = useContext(AppContext);

  const handleFriendRemove = (id) => {
    setFriends(vrienden.filter((friend) => friend.id !== id));
  };

  return (
    <>
      <div>{`Hallo ${name}`}</div>
      <h1>Hieronder een lijst van je vrienden</h1>
      <ul>
        {vrienden.map(({ id, name }) => (
          <li
            style={{
              listStyle: "none",
            }}
            key={id}
          >
            {name}
            <button
              style={{
                hover: "cursor-pointer",
                maginLeft: "10px",
                fontSize: "12x",
              }}
              onClick={() => handleFriendRemove(id)}
            >
              delete
            </button>
          </li>
        ))}
      </ul>
    </>
  );
};

export default Welkom;
