import React, { createContext, useState, useContext, useEffect } from 'react';
import { authAPI } from '../services/api';

const AuthContext = createContext();

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [company, setCompany] = useState(null);
  const [token, setToken] = useState(localStorage.getItem('token'));
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const initAuth = async () => {
      const savedToken = localStorage.getItem('token');
      const savedCompany = localStorage.getItem('company');
      
      if (savedToken) {
        setToken(savedToken);
        
        // Restore company from localStorage
        if (savedCompany) {
          const companyData = JSON.parse(savedCompany);
          setCompany(companyData);
          applyTheme(companyData);
        }
        
        // Load user data
        await loadUser();
      } else {
        setLoading(false);
      }
    };
    
    initAuth();
  }, []);

  const loadUser = async () => {
    try {
      const response = await authAPI.getUser();
      setUser(response.data.user);
      setCompany(response.data.company);
      applyTheme(response.data.company);
    } catch (error) {
      console.error('Failed to load user:', error);
      // Only logout if token is invalid (401/403)
      if (error.response?.status === 401 || error.response?.status === 403) {
        logout();
      }
    } finally {
      setLoading(false);
    }
  };

  const login = async (credentials) => {
    try {
      const response = await authAPI.login(credentials);
      const { token, user, company } = response.data;
      
      localStorage.setItem('token', token);
      localStorage.setItem('company', JSON.stringify(company));
      
      setToken(token);
      setUser(user);
      setCompany(company);
      
      // Apply theme
      applyTheme(company);
      
      return { success: true };
    } catch (error) {
      return { 
        success: false, 
        error: error.response?.data?.error || 'Login failed' 
      };
    }
  };

  const logout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('company');
    setToken(null);
    setUser(null);
    setCompany(null);
    
    // Reset theme
    document.documentElement.style.setProperty('--primary-color', '#3490dc');
    document.documentElement.style.setProperty('--accent-color', '#ffcc00');
  };

  const applyTheme = (company) => {
    if (company.primary_color) {
      document.documentElement.style.setProperty('--primary-color', company.primary_color);
    }
    if (company.accent_color) {
      document.documentElement.style.setProperty('--accent-color', company.accent_color);
    }
  };

  const value = {
    user,
    company,
    token,
    loading,
    login,
    logout,
    isAuthenticated: !!token,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};