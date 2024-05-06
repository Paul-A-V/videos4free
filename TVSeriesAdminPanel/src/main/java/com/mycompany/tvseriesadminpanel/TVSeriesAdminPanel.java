package com.mycompany.tvseriesadminpanel;

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
import java.sql.*;

public class TVSeriesAdminPanel extends JFrame implements ActionListener {
    private JButton addButton, updateButton, deleteButton;
    private Connection conn;

    public TVSeriesAdminPanel() {
        super("TV Series Admin Panel");
        initializeGUI();
        connectToDatabase();
    }

    private void initializeGUI() {
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLayout(new FlowLayout());

        addButton = new JButton("Add TV Series");
        updateButton = new JButton("Update TV Series");
        deleteButton = new JButton("Delete TV Series");

        addButton.addActionListener(this);
        updateButton.addActionListener(this);
        deleteButton.addActionListener(this);

        add(addButton);
        add(updateButton);
        add(deleteButton);

        pack();
        setLocationRelativeTo(null);
        setVisible(true);
    }

    private void connectToDatabase() {
        try {
            String url = "jdbc:mysql://localhost:3306/videos4free";
            String username = "root";
            String password = "";

            conn = DriverManager.getConnection(url, username, password);
        } catch (SQLException e) {
            e.printStackTrace();
            JOptionPane.showMessageDialog(null, "Failed to connect to the database");
            System.exit(1);
        }
    }

    @Override
    public void actionPerformed(ActionEvent e) {
        if (e.getSource() == addButton) {
            AddTVSeriesDialog addTVSeriesDialog = new AddTVSeriesDialog(this, conn);
            addTVSeriesDialog.setVisible(true);
        } else if (e.getSource() == updateButton) {
            UpdateTVSeriesDialog updateTVSeriesDialog = new UpdateTVSeriesDialog(this, conn);
            updateTVSeriesDialog.setVisible(true);
        } else if (e.getSource() == deleteButton) {
            DeleteTVSeriesDialog deleteTVSeriesDialog = new DeleteTVSeriesDialog(this, conn);
            deleteTVSeriesDialog.setVisible(true);
        }
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(TVSeriesAdminPanel::new);
    }
}


