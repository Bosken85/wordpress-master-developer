import { motion } from 'framer-motion'
import { Button } from '@/components/ui/button.jsx'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'
import { Badge } from '@/components/ui/badge.jsx'
import { CheckCircle, Code, Database, Globe, Zap, Shield, Users, Award, ArrowRight } from 'lucide-react'
import { Link } from 'react-router-dom'

// Import assets
import workspaceImg from '../assets/workspace.jpg'

function About() {
  const expertise = [
    "Custom WordPress theme development from scratch",
    "Popular plugins integration (WooCommerce, ACF, Contact Form 7)",
    "Major theme builders compatibility (Elementor, Divi, Beaver Builder)",
    "WordPress template hierarchy mastery",
    "Theme Customizer implementation",
    "Hooks and filters expertise",
    "Performance and security optimization",
    "Responsive design and mobile optimization",
    "SEO best practices implementation",
    "Cross-browser compatibility testing"
  ]

  const skills = [
    { name: "PHP", level: 95, icon: <Code className="w-6 h-6" /> },
    { name: "WordPress", level: 98, icon: <Globe className="w-6 h-6" /> },
    { name: "JavaScript", level: 90, icon: <Code className="w-6 h-6" /> },
    { name: "CSS/SCSS", level: 92, icon: <Code className="w-6 h-6" /> },
    { name: "MySQL", level: 85, icon: <Database className="w-6 h-6" /> },
    { name: "Performance Optimization", level: 88, icon: <Zap className="w-6 h-6" /> }
  ]

  const achievements = [
    {
      icon: <Award className="w-8 h-8" />,
      title: "500+ WordPress Themes",
      description: "Successfully developed and deployed custom WordPress themes for clients worldwide"
    },
    {
      icon: <Users className="w-8 h-8" />,
      title: "200+ Happy Clients",
      description: "Delivered exceptional WordPress solutions that exceed client expectations"
    },
    {
      icon: <Shield className="w-8 h-8" />,
      title: "99.9% Uptime",
      description: "Maintained excellent performance and security standards across all projects"
    },
    {
      icon: <Zap className="w-8 h-8" />,
      title: "Fast Loading Sites",
      description: "Optimized themes achieve average loading times under 2 seconds"
    }
  ]

  const values = [
    {
      title: "Quality First",
      description: "Every line of code is written with precision, following WordPress coding standards and best practices."
    },
    {
      title: "Performance Focused",
      description: "Optimizing for speed, security, and scalability to ensure your website performs at its best."
    },
    {
      title: "Client-Centric",
      description: "Understanding your unique requirements and delivering solutions that align with your business goals."
    },
    {
      title: "Continuous Learning",
      description: "Staying updated with the latest WordPress developments and web technologies to provide cutting-edge solutions."
    }
  ]

  return (
    <div className="min-h-screen bg-background pt-20">
      {/* Hero Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="text-center mb-16"
          >
            <h1 className="text-5xl md:text-6xl font-bold mb-6">About WordPress Master Developer</h1>
            <p className="text-xl text-muted-foreground max-w-4xl mx-auto">
              Passionate about creating exceptional WordPress experiences through expert development, innovative solutions, and unwavering commitment to quality.
            </p>
          </motion.div>
        </div>
      </section>

      {/* Main About Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 gap-12 items-center mb-20">
            <motion.div
              initial={{ opacity: 0, x: -30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-4xl font-bold mb-6">Your Trusted WordPress Development Partner</h2>
              <p className="text-lg text-muted-foreground mb-6">
                I am a WordPress Master Developer with comprehensive expertise in both management and development of WordPress websites. My deep understanding of PHP, CSS, HTML, and JavaScript, combined with extensive knowledge of web development principles, allows me to create exceptional WordPress solutions.
              </p>
              <p className="text-lg text-muted-foreground mb-8">
                With years of experience in the WordPress ecosystem, I specialize in creating custom themes that are not only visually stunning but also performance-optimized, secure, and built to scale with your business needs.
              </p>
              <Link to="/contact">
                <Button className="bg-orange-500 hover:bg-orange-600 text-white">
                  Start Your Project <ArrowRight className="ml-2 w-4 h-4" />
                </Button>
              </Link>
            </motion.div>
            <motion.div
              initial={{ opacity: 0, x: 30 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
              className="relative"
            >
              <img 
                src={workspaceImg} 
                alt="Professional WordPress Development Workspace" 
                className="rounded-lg shadow-2xl"
              />
              <div className="absolute inset-0 bg-gradient-to-tr from-orange-500/20 to-transparent rounded-lg"></div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Expertise Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Core Expertise & Capabilities</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Comprehensive WordPress development skills covering every aspect of theme creation and optimization.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 gap-8 mb-16">
            {expertise.map((item, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, x: -20 }}
                whileInView={{ opacity: 1, x: 0 }}
                transition={{ duration: 0.4, delay: index * 0.1 }}
                viewport={{ once: true }}
                className="flex items-center space-x-3"
              >
                <CheckCircle className="w-5 h-5 text-green-500 flex-shrink-0" />
                <span className="text-foreground">{item}</span>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Skills Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Technical Skills & Proficiency</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Mastery of essential technologies and tools for WordPress development.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {skills.map((skill, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="h-full">
                  <CardHeader>
                    <div className="flex items-center space-x-3 mb-4">
                      <div className="w-12 h-12 bg-orange-500/10 rounded-lg flex items-center justify-center text-orange-500">
                        {skill.icon}
                      </div>
                      <div>
                        <CardTitle className="text-xl">{skill.name}</CardTitle>
                        <Badge variant="secondary">{skill.level}% Proficiency</Badge>
                      </div>
                    </div>
                  </CardHeader>
                  <CardContent>
                    <div className="w-full bg-gray-200 rounded-full h-2">
                      <motion.div
                        className="bg-orange-500 h-2 rounded-full"
                        initial={{ width: 0 }}
                        whileInView={{ width: `${skill.level}%` }}
                        transition={{ duration: 1, delay: index * 0.1 }}
                        viewport={{ once: true }}
                      ></motion.div>
                    </div>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Achievements Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Achievements & Milestones</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Proven track record of delivering exceptional WordPress solutions and exceeding client expectations.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {achievements.map((achievement, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
                className="text-center"
              >
                <div className="w-16 h-16 bg-orange-500/10 rounded-lg flex items-center justify-center mx-auto mb-6 text-orange-500">
                  {achievement.icon}
                </div>
                <h3 className="text-2xl font-bold mb-4">{achievement.title}</h3>
                <p className="text-muted-foreground">{achievement.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Values Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-6">Our Core Values</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              The principles that guide every project and client relationship.
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 gap-8">
            {values.map((value, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="h-full hover:shadow-lg transition-all duration-300">
                  <CardHeader>
                    <CardTitle className="text-2xl text-orange-500">{value.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-base text-muted-foreground">
                      {value.description}
                    </CardDescription>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center"
          >
            <h2 className="text-4xl font-bold mb-6">Ready to Work Together?</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto mb-8">
              Let's discuss your WordPress project and create something amazing together.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Link to="/services">
                <Button variant="outline" className="border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white">
                  View Our Services
                </Button>
              </Link>
              <Link to="/contact">
                <Button className="bg-orange-500 hover:bg-orange-600 text-white">
                  Get In Touch <ArrowRight className="ml-2 w-4 h-4" />
                </Button>
              </Link>
            </div>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default About
