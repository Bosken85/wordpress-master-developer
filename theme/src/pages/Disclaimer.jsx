import { motion } from 'framer-motion'
import { AlertTriangle, Shield, Info, ExternalLink, Clock, Target } from 'lucide-react'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'

function Disclaimer() {
  const lastUpdated = "September 18, 2025"

  const disclaimerSections = [
    {
      icon: <Info className="w-6 h-6" />,
      title: "General Information",
      description: "Our website content is provided for informational purposes only and should not be considered as professional advice for specific situations."
    },
    {
      icon: <Target className="w-6 h-6" />,
      title: "Service Results",
      description: "While we strive for excellence, we cannot guarantee specific outcomes, rankings, or performance metrics for WordPress development projects."
    },
    {
      icon: <ExternalLink className="w-6 h-6" />,
      title: "Third-Party Links",
      description: "Our website may contain links to external sites. We are not responsible for the content, privacy practices, or availability of these sites."
    },
    {
      icon: <Clock className="w-6 h-6" />,
      title: "Information Accuracy",
      description: "We make every effort to ensure information accuracy, but content may become outdated or contain errors despite our best efforts."
    }
  ]

  return (
    <div className="min-h-screen bg-background">
      {/* Hero Section */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="text-center mb-16"
          >
            <div className="w-16 h-16 bg-orange-500/10 rounded-lg flex items-center justify-center mx-auto mb-6 text-orange-500">
              <AlertTriangle className="w-8 h-8" />
            </div>
            <h1 className="text-5xl md:text-6xl font-bold mb-6">Disclaimer</h1>
            <p className="text-xl text-muted-foreground max-w-4xl mx-auto">
              Important information about the use of our website, services, and the limitations of our liability and warranties.
            </p>
            <p className="text-sm text-muted-foreground mt-4">
              Last updated: {lastUpdated}
            </p>
          </motion.div>
        </div>
      </section>

      {/* Key Disclaimer Points */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-12"
          >
            <h2 className="text-3xl font-bold mb-6">Key Disclaimer Points</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Understanding the important limitations and considerations when using our services
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            {disclaimerSections.map((section, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="h-full">
                  <CardHeader>
                    <div className="w-12 h-12 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4 text-orange-500">
                      {section.icon}
                    </div>
                    <CardTitle className="text-xl">{section.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-base">
                      {section.description}
                    </CardDescription>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Detailed Disclaimer */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="space-y-12">
            {/* Website Content Disclaimer */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Website Content and Information</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  The information contained on this website is for general information purposes only. While we endeavor to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability, or availability of the website or the information, products, services, or related graphics contained on the website.
                </p>
                <p className="mb-4">
                  Any reliance you place on such information is therefore strictly at your own risk. In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website.
                </p>
              </div>
            </motion.div>

            {/* Service Performance Disclaimer */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Service Performance and Results</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  While we strive to provide high-quality WordPress development services, we cannot guarantee specific results, performance metrics, or outcomes. Factors affecting website performance include but are not limited to:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Hosting environment and server configuration</li>
                  <li>Third-party plugin compatibility and updates</li>
                  <li>Content quality and optimization</li>
                  <li>Search engine algorithm changes</li>
                  <li>Market conditions and competition</li>
                  <li>User behavior and technical factors beyond our control</li>
                </ul>
                <p>
                  Results may vary based on individual circumstances, and past performance does not guarantee future results.
                </p>
              </div>
            </motion.div>

            {/* Third-Party Services */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Third-Party Services and Links</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  Our website may contain links to other websites or references to third-party services, plugins, or tools. These links are provided for your convenience and information only. We have no control over the nature, content, and availability of those sites or services.
                </p>
                <p className="mb-4">
                  The inclusion of any links or references does not necessarily imply a recommendation or endorse the views expressed within them. We are not responsible for:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>The content, privacy policies, or practices of third-party websites</li>
                  <li>The functionality or security of third-party plugins or services</li>
                  <li>Any damages or losses arising from the use of third-party services</li>
                  <li>Changes to third-party services that may affect your website</li>
                </ul>
              </div>
            </motion.div>

            {/* Technical Limitations */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Technical Limitations and Compatibility</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  WordPress is an evolving platform with regular updates to its core, themes, and plugins. We cannot guarantee:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Compatibility with all future WordPress updates</li>
                  <li>Compatibility with all third-party plugins and themes</li>
                  <li>Functionality across all browsers and devices</li>
                  <li>Performance on all hosting environments</li>
                  <li>Immunity from security vulnerabilities</li>
                </ul>
                <p>
                  Regular maintenance and updates are recommended to ensure optimal performance and security.
                </p>
              </div>
            </motion.div>

            {/* Professional Advice Disclaimer */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Professional Advice</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  The information and services provided on this website are not intended to constitute professional advice for your specific situation. While we have expertise in WordPress development, we recommend consulting with appropriate professionals for:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Legal compliance and regulatory requirements</li>
                  <li>Financial and business strategy decisions</li>
                  <li>Security and data protection assessments</li>
                  <li>Accessibility compliance and standards</li>
                  <li>Industry-specific requirements and regulations</li>
                </ul>
              </div>
            </motion.div>

            {/* Availability and Downtime */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Website Availability</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  We strive to ensure that our website is available 24/7, but we cannot guarantee uninterrupted access. The website may be temporarily unavailable due to:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Scheduled maintenance and updates</li>
                  <li>Technical issues or server problems</li>
                  <li>Internet connectivity issues</li>
                  <li>Force majeure events beyond our control</li>
                </ul>
                <p>
                  We will make reasonable efforts to minimize downtime and provide advance notice when possible.
                </p>
              </div>
            </motion.div>

            {/* Intellectual Property */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Intellectual Property</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  All content on this website, including text, graphics, logos, images, and software, is the property of WordPress Master Developer or its content suppliers and is protected by copyright and other intellectual property laws.
                </p>
                <p className="mb-4">
                  You may not reproduce, distribute, or create derivative works from our content without explicit written permission. However, you may:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>View and print pages for personal, non-commercial use</li>
                  <li>Share links to our content on social media</li>
                  <li>Quote brief excerpts with proper attribution</li>
                </ul>
              </div>
            </motion.div>

            {/* Changes to Disclaimer */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">Changes to This Disclaimer</h2>
              <div className="prose prose-lg max-w-none">
                <p>
                  We reserve the right to modify this disclaimer at any time without prior notice. Changes will be effective immediately upon posting on our website. Your continued use of our website and services after any changes constitutes acceptance of the modified disclaimer. We recommend reviewing this disclaimer periodically to stay informed of any updates.
                </p>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Contact and Legal */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <Card className="h-full">
                <CardHeader>
                  <Shield className="w-8 h-8 text-orange-500 mb-2" />
                  <CardTitle className="text-xl">Legal Compliance</CardTitle>
                </CardHeader>
                <CardContent>
                  <p className="text-muted-foreground mb-4">
                    This disclaimer is governed by applicable international business law and regulations. Any disputes arising from the use of our website or services will be resolved according to our Terms of Service.
                  </p>
                  <p className="text-sm text-muted-foreground">
                    For specific legal questions, please consult with qualified legal counsel.
                  </p>
                </CardContent>
              </Card>
            </motion.div>

            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.1 }}
              viewport={{ once: true }}
            >
              <Card className="h-full">
                <CardHeader>
                  <Info className="w-8 h-8 text-orange-500 mb-2" />
                  <CardTitle className="text-xl">Questions or Clarifications</CardTitle>
                </CardHeader>
                <CardContent>
                  <p className="text-muted-foreground mb-4">
                    If you have any questions about this disclaimer or need clarification on any points, please don't hesitate to contact us.
                  </p>
                  <div className="space-y-2 text-sm">
                    <div className="flex items-center space-x-2">
                      <span>📧</span>
                      <span>contact@wpmaster.dev</span>
                    </div>
                    <div className="flex items-center space-x-2">
                      <span>📞</span>
                      <span>+1 (555) 123-4567</span>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Final Notice */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center max-w-3xl mx-auto"
          >
            <div className="bg-orange-500/10 border border-orange-500/20 rounded-lg p-8">
              <AlertTriangle className="w-12 h-12 text-orange-500 mx-auto mb-4" />
              <h2 className="text-2xl font-bold mb-4">Important Notice</h2>
              <p className="text-muted-foreground">
                By using our website and services, you acknowledge that you have read, understood, and agree to be bound by this disclaimer. If you do not agree with any part of this disclaimer, please discontinue use of our website and services immediately.
              </p>
            </div>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default Disclaimer
