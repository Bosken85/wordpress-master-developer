import { motion } from 'framer-motion'
import { FileText, Users, Shield, AlertTriangle, Scale, Clock } from 'lucide-react'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'

function TermsOfService() {
  const lastUpdated = "September 18, 2025"

  const keyTerms = [
    {
      icon: <FileText className="w-6 h-6" />,
      title: "Service Agreement",
      description: "Professional WordPress development services with clear project scope and deliverables"
    },
    {
      icon: <Users className="w-6 h-6" />,
      title: "Client Responsibilities",
      description: "Timely feedback, content provision, and cooperation throughout the development process"
    },
    {
      icon: <Shield className="w-6 h-6" />,
      title: "Intellectual Property",
      description: "Clear ownership rights and licensing terms for all developed themes and code"
    },
    {
      icon: <Scale className="w-6 h-6" />,
      title: "Limitation of Liability",
      description: "Reasonable limitations on liability while ensuring quality service delivery"
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
            <h1 className="text-5xl md:text-6xl font-bold mb-6">Terms of Service</h1>
            <p className="text-xl text-muted-foreground max-w-4xl mx-auto">
              These terms govern the use of our WordPress development services and establish a clear framework for our professional relationship.
            </p>
            <p className="text-sm text-muted-foreground mt-4">
              Last updated: {lastUpdated}
            </p>
          </motion.div>
        </div>
      </section>

      {/* Key Terms Overview */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center mb-12"
          >
            <h2 className="text-3xl font-bold mb-6">Key Terms Overview</h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Understanding the essential elements of our service agreement
            </p>
          </motion.div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {keyTerms.map((term, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Card className="h-full text-center">
                  <CardHeader>
                    <div className="w-12 h-12 bg-orange-500/10 rounded-lg flex items-center justify-center mx-auto mb-4 text-orange-500">
                      {term.icon}
                    </div>
                    <CardTitle className="text-lg">{term.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-sm">
                      {term.description}
                    </CardDescription>
                  </CardContent>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Detailed Terms */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="space-y-12">
            {/* Acceptance of Terms */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">1. Acceptance of Terms</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  By accessing our website or engaging our WordPress development services, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using our services.
                </p>
                <p>
                  These terms constitute a legally binding agreement between you ("Client") and WordPress Master Developer ("Service Provider," "we," "us," or "our").
                </p>
              </div>
            </motion.div>

            {/* Services Description */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">2. Services Description</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  WordPress Master Developer provides professional WordPress development services including:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Custom WordPress theme development from scratch</li>
                  <li>Plugin integration and customization</li>
                  <li>Performance optimization and security implementation</li>
                  <li>Installation wizard development</li>
                  <li>Ongoing maintenance and support services</li>
                </ul>
                <p>
                  All services are provided according to industry best practices and WordPress coding standards.
                </p>
              </div>
            </motion.div>

            {/* Project Scope and Deliverables */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">3. Project Scope and Deliverables</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  Each project begins with a detailed scope definition that includes:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Specific deliverables and functionality requirements</li>
                  <li>Project timeline and milestones</li>
                  <li>Pricing structure and payment terms</li>
                  <li>Revision and change request procedures</li>
                </ul>
                <p>
                  Any changes to the agreed scope must be documented and may result in additional charges and timeline adjustments.
                </p>
              </div>
            </motion.div>

            {/* Payment Terms */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">4. Payment Terms</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  Payment terms are established for each project and typically include:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Initial deposit required to commence work (usually 50%)</li>
                  <li>Milestone-based payments for larger projects</li>
                  <li>Final payment due upon project completion</li>
                  <li>Net 15-day payment terms for invoices</li>
                </ul>
                <p>
                  Late payments may result in project suspension and additional fees. All prices are quoted in USD unless otherwise specified.
                </p>
              </div>
            </motion.div>

            {/* Client Responsibilities */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">5. Client Responsibilities</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  To ensure successful project completion, clients are responsible for:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Providing timely feedback and approvals</li>
                  <li>Supplying necessary content, images, and materials</li>
                  <li>Ensuring access to hosting and domain accounts when required</li>
                  <li>Communicating requirements clearly and promptly</li>
                  <li>Testing deliverables and reporting issues within agreed timeframes</li>
                </ul>
                <p>
                  Delays in client responsibilities may impact project timelines and costs.
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
              <h2 className="text-3xl font-bold mb-6">6. Intellectual Property Rights</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  Upon full payment, clients receive:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Full ownership rights to custom-developed themes and code</li>
                  <li>Source files and documentation</li>
                  <li>Rights to modify and distribute the developed themes</li>
                </ul>
                <p className="mb-4">
                  We retain the right to:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Showcase completed work in our portfolio</li>
                  <li>Use general techniques and methodologies in future projects</li>
                  <li>Retain ownership of proprietary tools and frameworks</li>
                </ul>
              </div>
            </motion.div>

            {/* Warranties and Disclaimers */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">7. Warranties and Disclaimers</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  We warrant that our services will be performed with professional skill and care. However:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>We cannot guarantee specific search engine rankings or traffic results</li>
                  <li>Third-party plugin compatibility may change over time</li>
                  <li>Website performance depends on hosting environment and configuration</li>
                  <li>We are not responsible for content provided by the client</li>
                </ul>
                <p>
                  All services are provided "as is" without warranty of any kind beyond what is explicitly stated.
                </p>
              </div>
            </motion.div>

            {/* Limitation of Liability */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">8. Limitation of Liability</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  Our total liability for any claims arising from our services shall not exceed the total amount paid by the client for the specific project in question. We shall not be liable for:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Indirect, incidental, or consequential damages</li>
                  <li>Loss of profits, data, or business opportunities</li>
                  <li>Damages resulting from third-party actions or services</li>
                  <li>Issues arising from client-provided content or materials</li>
                </ul>
              </div>
            </motion.div>

            {/* Termination */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">9. Termination</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  Either party may terminate the service agreement with written notice. Upon termination:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Client is responsible for payment of all work completed to date</li>
                  <li>We will deliver all completed work and source files</li>
                  <li>Ongoing support and maintenance services will cease</li>
                  <li>Confidentiality obligations remain in effect</li>
                </ul>
              </div>
            </motion.div>

            {/* Governing Law */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">10. Governing Law and Disputes</h2>
              <div className="prose prose-lg max-w-none">
                <p className="mb-4">
                  These terms are governed by applicable international business law. Any disputes will be resolved through:
                </p>
                <ul className="list-disc pl-6 space-y-2 mb-6">
                  <li>Good faith negotiation as the first step</li>
                  <li>Mediation if direct negotiation fails</li>
                  <li>Binding arbitration as a final resort</li>
                </ul>
              </div>
            </motion.div>

            {/* Changes to Terms */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              viewport={{ once: true }}
            >
              <h2 className="text-3xl font-bold mb-6">11. Changes to Terms</h2>
              <div className="prose prose-lg max-w-none">
                <p>
                  We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting on our website. Continued use of our services after changes constitutes acceptance of the modified terms. For ongoing projects, existing terms remain in effect until project completion.
                </p>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Contact Section */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="text-center max-w-3xl mx-auto"
          >
            <div className="bg-orange-500/10 rounded-lg p-8">
              <AlertTriangle className="w-12 h-12 text-orange-500 mx-auto mb-4" />
              <h2 className="text-2xl font-bold mb-4">Questions About These Terms?</h2>
              <p className="text-muted-foreground mb-6">
                If you have any questions about these Terms of Service or need clarification on any provisions, please contact us before engaging our services.
              </p>
              <div className="flex items-center justify-center space-x-6 text-sm">
                <span>📧 contact@wpmaster.dev</span>
                <span>📞 +1 (555) 123-4567</span>
              </div>
            </div>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default TermsOfService
