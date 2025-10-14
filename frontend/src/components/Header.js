import React from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import './Header.css';

const Header = () => {
  const { user, company, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  return (
    <header className="header">
      <div className="header-left">
        <h1 className="header-title">Company Dashboard</h1>
        {company?.logo_url ? (
          <img src={company.logo_url} alt={company.name} className="company-logo" />
        ) : (
          <span className="company-badge">{company?.name}</span>
        )}
      </div>
      <div className="header-right">
        <div className="user-info">
          <span className="user-name">{user?.full_name}</span>
          <span className="user-username">@{user?.username}</span>
        </div>
        <button onClick={handleLogout} className="logout-button">
          Logout
        </button>
      </div>
    </header>
  );
};

export default Header;