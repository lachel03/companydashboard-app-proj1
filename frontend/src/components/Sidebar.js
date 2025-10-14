import React, { useState } from 'react';
import './Sidebar.css';

const Sidebar = ({ modules, onSubmoduleClick }) => {
  const [expandedSystems, setExpandedSystems] = useState({});
  const [expandedModules, setExpandedModules] = useState({});
  const [searchQuery, setSearchQuery] = useState('');

  const toggleSystem = (systemId) => {
    setExpandedSystems(prev => ({
      ...prev,
      [systemId]: !prev[systemId]
    }));
  };

  const toggleModule = (moduleId) => {
    setExpandedModules(prev => ({
      ...prev,
      [moduleId]: !prev[moduleId]
    }));
  };

  const filterModules = (modules) => {
    if (!searchQuery) return modules;

    const query = searchQuery.toLowerCase();
    
    return modules.map(system => {
      const matchingModules = system.modules.filter(module => {
        const moduleMatch = module.module_name.toLowerCase().includes(query);
        const submoduleMatch = module.submodules.some(sub => 
          sub.name.toLowerCase().includes(query)
        );
        return moduleMatch || submoduleMatch;
      }).map(module => ({
        ...module,
        submodules: module.submodules.filter(sub =>
          sub.name.toLowerCase().includes(query) ||
          module.module_name.toLowerCase().includes(query)
        )
      }));

      if (matchingModules.length > 0 || system.system_name.toLowerCase().includes(query)) {
        return { ...system, modules: matchingModules };
      }
      return null;
    }).filter(Boolean);
  };

  const filteredModules = filterModules(modules);

  return (
    <aside className="sidebar">
      <div className="search-box">
        <input
          type="text"
          placeholder="Search modules..."
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          className="search-input"
        />
      </div>

      <nav className="module-tree">
        {filteredModules.length === 0 ? (
          <div className="no-results">No modules found</div>
        ) : (
          filteredModules.map((system) => (
            <div key={system.system_id} className="system-item">
              <div
                className="system-header"
                onClick={() => toggleSystem(system.system_id)}
              >
                <span className="expand-icon">
                  {expandedSystems[system.system_id] ? '▼' : '▶'}
                </span>
                <span className="system-name">{system.system_name}</span>
              </div>

              {expandedSystems[system.system_id] && (
                <div className="modules-container">
                  {system.modules.map((module) => (
                    <div key={module.module_id} className="module-item">
                      <div
                        className="module-header"
                        onClick={() => toggleModule(module.module_id)}
                      >
                        <span className="expand-icon">
                          {expandedModules[module.module_id] ? '▼' : '▶'}
                        </span>
                        <span className="module-name">{module.module_name}</span>
                      </div>

                      {expandedModules[module.module_id] && (
                        <div className="submodules-container">
                          {module.submodules.map((submodule) => (
                            <div
                              key={submodule.id}
                              className="submodule-item"
                              onClick={() => onSubmoduleClick(submodule)}
                            >
                              {submodule.name}
                            </div>
                          ))}
                        </div>
                      )}
                    </div>
                  ))}
                </div>
              )}
            </div>
          ))
        )}
      </nav>
    </aside>
  );
};

export default Sidebar;