/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Владимир
 */
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import java.io.File;
import java.io.IOException;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import java.beans.*;
import java.util.Random;
import java.util.Vector;


public class mocsparserUI extends javax.swing.JFrame{

    private TaskParsingEdx task;
    /**
     * Creates new form mocsparserUI
     */
    public mocsparserUI() {
        initComponents();
    }

    class Info{
        public Info(){
            schoolname = "";
            title = "";
            start = "";
            length = "";
            estimate = "";
            language = "";
            subtitles = "";
            about = "";
            staff = "";
            staff_profile = "";
            info = "";
            similar = "";
        }
        private String toString (Info info){
            String res = "    \"title\": \"" + info.title + "\"\n" + 
                        "    \"from\": \"" + info.schoolname + "\"\n" + 
                        "    \"start\": \"" + info.start + "\"\n" + 
                        "    \"length\": \"" + info.length + "\"\n" + 
                        "    \"estimate\": \"" + info.estimate + "\"\n" + 
                        "    \"staff\": \"" + info.staff + "\"\n" +
                        "    \"similar\": \"" + info.similar + "\"\n" +
                        "    \"language\": \"" + info.language + "\"\n" +
                        "    \"subtitles\": \"" + info.subtitles + "\"\n" +
                        "    \"description\": \"" + info.about + "\"\n" +
                        "    \"info\": \"" + info.info + "\"\n";
            return res;
        }
        String schoolname;
        String title;
        String start;
        String length;
        String estimate;
        String language;
        String subtitles;
        String about;
        String staff;
        String staff_profile;
        String similar;
        String info;
    }


    private Info parseEdxCourse(String url){
        Info info = new Info(); 
        Document doc_courses = null;
        try {
            doc_courses = Jsoup.connect(url).get();
        } catch (IOException e) {
            LogArea.append("!!!!Ошибка!!!! - " + e.toString()); 
            return null;
        }
        Element course_info = doc_courses.select("div[class=copy-detail course-detail-info views-fieldset]").first();
        Element school = course_info.select("div[class=course-detail-school item]").first();
        Elements staffs = doc_courses.select("div[class=course-staff-info views-fieldset]");
        for (Element staff_person: staffs)
        {
            //staff_person.attr(estimate)
        }
        info.schoolname = school.select("a").first().html();
        info.title = doc_courses.select("h2[class=course-detail-title]").first().text();
        if (!course_info.select("div[class=course-detail-start item]").isEmpty())
            info.start = course_info.select("div[class=course-detail-start item]").first().text();
        if (!course_info.select("div[class=course-detail-length item]").isEmpty())
            info.length = course_info.select("div[class=course-detail-length item]").first().text();
        if (!course_info.select("div[class=course-detail-effort item]").isEmpty())
            info.estimate = course_info.select("div[class=course-detail-effort item]").first().text();
        info.about = doc_courses.select("div[class=course-section course-detail-about]").first().text();

        return info;
    }
    
    private Info parseCourseraCourse(String url){
        Info info = new Info(); 
        Document doc_courses = null;
        try {
            doc_courses = Jsoup.connect(url).get();
            LogArea.append(doc_courses.html());
        } catch (IOException e) {
            LogArea.append("!!!!Ошибка!!!! - " + e.toString()); 
            return null;
        }
        info.info = doc_courses.html();
        //info.info = doc_courses.select("div[class=coursera-course2-data coursera-course2-course-at-glance]").first().html();
        Elements staffs = doc_courses.select("div[class=coursera-course2-instructors-profile]");
        if (!staffs.isEmpty())
        {
            for (Element staff: staffs)
            {
                String ref = staff.select("a").first().attr("href");
                info.staff += staff.text() + "\n" + ref + "\n";
            }
        }
        Elements similars = doc_courses.select("div[coursera-similartopics-course-name]");
        if (!similars.isEmpty())
        {
            for (Element similar: similars)
            {
                String ref = similar.select("a").first().attr("href");
                info.similar += similar.text() + "\n" + ref + "\n";;
            }
        }

        //info.about = doc_courses.select("div[class=coursera-course-detail]").first().text();

        return info;
    }
    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jScrollPane1 = new javax.swing.JScrollPane();
        LogArea = new javax.swing.JTextArea();
        jPanel1 = new javax.swing.JPanel();
        jCheckBox1 = new javax.swing.JCheckBox();
        jCheckBox2 = new javax.swing.JCheckBox();
        jCheckBox3 = new javax.swing.JCheckBox();
        jCheckBox4 = new javax.swing.JCheckBox();
        ProgressBar = new javax.swing.JProgressBar();
        buStart = new javax.swing.JButton();
        buStop = new javax.swing.JButton();
        jButton1 = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        LogArea.setColumns(20);
        LogArea.setRows(5);
        LogArea.addPropertyChangeListener(new java.beans.PropertyChangeListener() {
            public void propertyChange(java.beans.PropertyChangeEvent evt) {
                LogAreaPropertyChange(evt);
            }
        });
        jScrollPane1.setViewportView(LogArea);

        jCheckBox1.setText("jCheckBox1");

        jCheckBox2.setText("jCheckBox2");

        jCheckBox3.setText("jCheckBox3");

        jCheckBox4.setText("jCheckBox4");

        javax.swing.GroupLayout jPanel1Layout = new javax.swing.GroupLayout(jPanel1);
        jPanel1.setLayout(jPanel1Layout);
        jPanel1Layout.setHorizontalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jCheckBox1)
                    .addComponent(jCheckBox2)
                    .addComponent(jCheckBox3)
                    .addComponent(jCheckBox4))
                .addContainerGap(96, Short.MAX_VALUE))
        );
        jPanel1Layout.setVerticalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(jCheckBox1)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(jCheckBox2)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(jCheckBox3)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(jCheckBox4)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );

        ProgressBar.setToolTipText("");
        ProgressBar.addPropertyChangeListener(new java.beans.PropertyChangeListener() {
            public void propertyChange(java.beans.PropertyChangeEvent evt) {
                ProgressBarPropertyChange(evt);
            }
        });

        buStart.setText("Пуск");
        buStart.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                buStartActionPerformed(evt);
            }
        });

        buStop.setText("Стоп");
        buStop.setToolTipText("");
        buStop.setEnabled(false);
        buStop.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                buStopActionPerformed(evt);
            }
        });

        jButton1.setText("jButton1");
        jButton1.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton1ActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jScrollPane1)
                    .addComponent(ProgressBar, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addGroup(layout.createSequentialGroup()
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(layout.createSequentialGroup()
                                .addComponent(buStart)
                                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                                .addComponent(buStop))
                            .addGroup(layout.createSequentialGroup()
                                .addComponent(jPanel1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                                .addGap(160, 160, 160)
                                .addComponent(jButton1)))
                        .addGap(0, 458, Short.MAX_VALUE)))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(26, 26, 26)
                        .addComponent(jPanel1, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                        .addGap(18, 18, 18))
                    .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                        .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                        .addComponent(jButton1)
                        .addGap(45, 45, 45)))
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(buStart)
                    .addComponent(buStop))
                .addGap(9, 9, 9)
                .addComponent(ProgressBar, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 287, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap())
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    class TaskParsingMoocList extends SwingWorker<Void, Void> {
        /*
         * Main task. Executed in background thread.
         */
        @Override
        public Void doInBackground() {
            int progress = 0;
            float fProgress = 0;
            Document doc = null;
            Document doc_courses = null;
            Element next;
            Vector links = new Vector(); 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            try {
                doc = Jsoup.connect("https://www.edx.org/course-list").get();
            } catch (IOException e) {
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
            }
            boolean check1 = doc.select("li[class=pager-next odd]").isEmpty();
            boolean check2 = doc.select("li[class=pager-next even]").isEmpty();
            Elements course_titles = doc.select("h2[class=title course-title]");
            for(Element course_title : course_titles)
            {
                String s = course_title.select("a").first().attr("href");
                LogArea.append(s + "\n");
                links.add(s);
            }

            //собираем ссылки на курсы
            while (!doc.select("li[class=pager-next odd]").isEmpty())
            {
                next = doc.select("li[class=pager-next odd]").first();
                String s = next.select("a").first().attr("href");
                doc.empty();
                try {
                    doc = Jsoup.connect("https://www.edx.org" + s).get();
                } catch (IOException e) {
                    LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                }
                course_titles = doc.select("h2[class=title course-title]");
                for(Element course_title : course_titles)
                {
                    String tmp = course_title.select("a").first().attr("href");
                    LogArea.append(tmp + "\n");
                    links.add(tmp);
                }
            }
            
            //вычисляем шаг для прогресса и пошагово открываем все ссылки
            int courseNum = links.toArray().length;
            LogArea.append("CoursesNum = " + Integer.toString(courseNum));
            float step = 100f/courseNum;
            LogArea.append("step = " + Float.toString(step));
            
            for (Object link: links)
            {
                LogArea.append("{"+"\n");
                if (doc_courses!=null)
                    doc_courses.empty();
                
                fProgress += step;
                progress = Math.round(fProgress); 
                ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
                LogArea.append("},"+"\n");
            }
            progress = 100; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            return null;
        }
        

        /*
         * Executed in event dispatching thread
         */
        @Override
        public void done() {
            buStart.setEnabled(true);
            buStop.setEnabled(false);
        }
    }
        
    class TaskParsingEdx extends SwingWorker<Void, Void> {
        /*
         * Main task. Executed in background thread.
         */
        @Override
        public Void doInBackground() {
            int progress = 0;
            float fProgress = 0;
            Document doc = null;
            Element next;
            Vector links = new Vector(); 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            try {
                doc = Jsoup.connect("https://www.edx.org/course-list").get();
            } catch (IOException e) {
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
            }
            boolean check1 = doc.select("li[class=pager-next odd]").isEmpty();
            boolean check2 = doc.select("li[class=pager-next even]").isEmpty();
            Elements course_titles = doc.select("h2[class=title course-title]");
            for(Element course_title : course_titles)
            {
                String s = course_title.select("a").first().attr("href");
                LogArea.append(s + "\n");
                links.add(s);
            }

            //собираем ссылки на курсы
            while (!doc.select("li[class=pager-next odd]").isEmpty())
            {
                next = doc.select("li[class=pager-next odd]").first();
                String s = next.select("a").first().attr("href");
                doc.empty();
                try {
                    doc = Jsoup.connect("https://www.edx.org" + s).get();
                } catch (IOException e) {
                    LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                }
                course_titles = doc.select("h2[class=title course-title]");
                for(Element course_title : course_titles)
                {
                    String tmp = course_title.select("a").first().attr("href");
                    LogArea.append(tmp + "\n");
                    links.add(tmp);
                }
            }
            
            //вычисляем шаг для прогресса и пошагово открываем все ссылки
            int courseNum = links.toArray().length;
            float step = 100f/courseNum;
            
            for (Object link: links)
            {
                Info info = null;
                LogArea.append("{"+"\n");
                info = parseEdxCourse(link.toString());
                LogArea.append("    \"title\": \"" + info.title + "\"\n" + 
                               "    \"platform\": \"EdX\"\n" + 
                               "    \"from\": \"" + info.schoolname + "\"\n" + 
                               "    \"start\": \"" + info.start + "\"\n" + 
                               "    \"length\": \"" + info.length + "\"\n" + 
                               "    \"estimate\": \"" + info.estimate + "\"\n" + 
                               "    \"language\": \"" + "\"\n" +
                               "    \"subtitles\": \"" + "\"\n" +
                               "    \"description\": \"" + info.about + "\"\n");
                LogArea.append("},"+"\n");
                fProgress += step;
                progress = Math.round(fProgress); 
                ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            }
            progress = 100; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            return null;
        }
        

        /*
         * Executed in event dispatching thread
         */
        @Override
        public void done() {
            buStart.setEnabled(true);
            buStop.setEnabled(false);
        }
    }
    
    class TaskParsingMyeducationkey extends SwingWorker<Void, Void> {
        /*
         * Main task. Executed in background thread.
         */
        @Override
        public Void doInBackground() {
            int progress = 0;
            float fProgress = 0;
            //Initialize progress property.
            setProgress(0);
            Document doc = null;
            Document courses_doc = null;
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            try {
                doc = Jsoup.connect("http://www.myeducationkey.com/").get();
            } catch (IOException e) {
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
            }
            Element university_education = doc.select("#subject-base").first(); 
            Elements specs = university_education.select("a.box-title");
            int specNum = specs.toArray().length;
            float step = 100/specNum;
            int departmentNum = -1;
            float departmentStep;
            int coursesNum = -1;
            float coursesStep;
            for(Element spec : specs)
            {
                doc.empty();
                try {
                    doc = Jsoup.connect(spec.attr("href")).get();
                } catch (IOException e) {
                    LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                }
                String spec_title = doc.select("a.title").first().html().toString();
                Elements departments = doc.select("a.department-img-title");
                
                departmentNum = departments.toArray().length;
                departmentStep =  step/departmentNum;
                for (Element department: departments)
                {
                    if (courses_doc!=null)
                        courses_doc.empty();

                    try {
                        courses_doc = Jsoup.connect(department.attr("href")).get();
                    } catch (IOException e) {
                        LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                    }
                    Elements courses = courses_doc.select("div#main-sub-dpm-base");
                    coursesNum = courses.toArray().length;
                    coursesStep = departmentStep/coursesNum;
                    for (Element course: courses)
                    {
                        String course_from = course.select("div.sub-dpm-sub-title").first().html().toString();
                        Element course_title = course.select("a.sub-dpm-title").first();
                        courses_doc.empty();
                        try {
                            courses_doc = Jsoup.connect(course_title.attr("href")).get();
                        } catch (IOException e) {
                            LogArea.append("!!!!Ошибка!!!! - " + e.toString());

                            continue;
                        } 
                        String course_desc = courses_doc.select("div.text").first().html().toString().replaceAll("\r\n", " ");
                        LogArea.append("    \"speciality\": \"" + spec_title + "\"," + " \n");
                        LogArea.append("    \"department\": \"" + department.html().toString() + "\"," + " \n");
                        LogArea.append("    \"title\": \"" + course_title.html().toString() + "\"," + " \n");
                        LogArea.append("    \"from\": \"" + course_from + "\"," + " \n");
                        LogArea.append("    \"description\": \"" + course_desc.trim() + "\"" + " \n");
                        LogArea.append("}," + " \n");
                      
                        fProgress += coursesStep;
                        progress = Math.round(fProgress); 
                        ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
                    }
                }
            }
            progress = 100; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            return null;
        }
        

        /*
         * Executed in event dispatching thread
         */
        @Override
        public void done() {
            Toolkit.getDefaultToolkit().beep();
            buStart.setEnabled(true);
            buStop.setEnabled(false);
            setCursor(null); //turn off the wait cursor
            LogArea.append("Done!\n");
        }
    }
    
    private void buStartActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_buStartActionPerformed
        ProgressBar.setStringPainted(true);
        task = new TaskParsingEdx();
        task.execute();
        buStart.setEnabled(false);
        buStop.setEnabled(true);
    }//GEN-LAST:event_buStartActionPerformed

    private void ProgressBarPropertyChange(java.beans.PropertyChangeEvent evt) {//GEN-FIRST:event_ProgressBarPropertyChange
        if ("progress" == evt.getPropertyName()) {
            int progress = (Integer) evt.getNewValue();
            ProgressBar.setValue(progress);
           // jTextArea1.append(String.format(
            //        "Completed %d%% of task.\n", progress));
        } 
    }//GEN-LAST:event_ProgressBarPropertyChange

    private void LogAreaPropertyChange(java.beans.PropertyChangeEvent evt) {//GEN-FIRST:event_LogAreaPropertyChange
        // TODO add your handling code here:
    }//GEN-LAST:event_LogAreaPropertyChange

    private void buStopActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_buStopActionPerformed
        boolean flag;
        flag = task.cancel(true);
        while (!flag)
            flag = task.cancel(true);
        buStop.setEnabled(false);
    }//GEN-LAST:event_buStopActionPerformed

    private void jButton1ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton1ActionPerformed
       Info info = parseCourseraCourse("https://www.coursera.org/course/megafauna");
       LogArea.append(info.toString());
    }//GEN-LAST:event_jButton1ActionPerformed

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new mocsparserUI().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JTextArea LogArea;
    private javax.swing.JProgressBar ProgressBar;
    private javax.swing.JButton buStart;
    private javax.swing.JButton buStop;
    private javax.swing.JButton jButton1;
    private javax.swing.JCheckBox jCheckBox1;
    private javax.swing.JCheckBox jCheckBox2;
    private javax.swing.JCheckBox jCheckBox3;
    private javax.swing.JCheckBox jCheckBox4;
    private javax.swing.JPanel jPanel1;
    private javax.swing.JScrollPane jScrollPane1;
    // End of variables declaration//GEN-END:variables
}
