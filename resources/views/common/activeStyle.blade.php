<style>
    .custom-select {
      position: relative;
      width: 100%; 
      border: 1px solid #ccc;
    }
    
    .select-selected {
      background-color: #fff;
      padding: 8px 8px;
      cursor: pointer;
    }
    
    .select-items {
      display: none;
      position: absolute;
      background-color: #fff;
      width: 100%; 
      max-height: 200px; 
      overflow-y: auto; 
      border: 1px solid #ccc;
      z-index: 1;
    
    }
    
    .select-items div:hover {
      background-color: #007bff;
      color: black;
    }
    
    .show {
      display: block;
    }
    
</style>