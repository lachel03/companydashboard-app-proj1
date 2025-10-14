import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { moduleAPI } from '../services/api';
import Sidebar from '../components/Sidebar';
import Header from '../components/Header';
import './Dashboard.css';

const Dashboard = () => {
  const [modules, setModules] = useState([]);
  const [selectedSubmodule, setSelectedSubmodule] = useState(null);
  const [loading, setLoading] = useState(true);
  
  const { user, company, isAuthenticated } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    if (!isAuthenticated) {
      navigate('/login');
      return;
    }
    fetchModules();
  }, [isAuthenticated, navigate]);

  const fetchModules = async () => {
    try {
      const response = await moduleAPI.getModules();
      setModules(response.data);
    } catch (error) {
      console.error('Failed to fetch modules:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmoduleClick = (submodule) => {
    setSelectedSubmodule(submodule);
  };

  if (loading) {
    return <div className="loading">Loading...</div>;
  }

  return (
    <div className="dashboard">
      <Header />
      <div className="dashboard-content">
        <Sidebar 
          modules={modules} 
          onSubmoduleClick={handleSubmoduleClick}
        />
        <main className="main-content">
          {selectedSubmodule ? (
            <div className="content-area">
              <h2>{selectedSubmodule.name}</h2>
              <p>Route: {selectedSubmodule.route}</p>
              <p>This is a placeholder for {selectedSubmodule.name} content.</p>
            </div>
          ) : (
            <div className="welcome-screen">
              <h1>Welcome, {user?.full_name}!</h1>
              <p>Company: <strong>{company?.name}</strong></p>
              <p>Select a module from the sidebar to get started.</p>
            </div>
          )}
        </main>
      </div>
    </div>
  );
};

export default Dashboard;